<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\CompanyPublicInfo;

class TaxWebAPITestController extends Controller
{
    
    private $comp_type = [
        ['id'=>'101','def'=>'国の機関'],
        ['id'=>'201','def'=>'地方公共団体'],
        ['id'=>'301','def'=>'株式会社'],
        ['id'=>'302','def'=>'有限会社'],
        ['id'=>'303','def'=>'合名会社'],
        ['id'=>'304','def'=>'合資会社'],
        ['id'=>'305','def'=>'合同会社'],
        ['id'=>'399','def'=>'その他の設立登記法人'],
        ['id'=>'401','def'=>'外国会社等'],
        ['id'=>'499','def'=>'その他'],
       ];
    //    
    public function index() {
        Log::info('Log index');

        return view('TaxWebAPI.index');
    }

    public function get1(Request $request) {
        $app_id = config('app.TAX_AGENCY_APPLICATION_ID');

        $message =
        [
          'function' => "TaxWebAPITestController.get1",
          'timing' => 'start function ',
          'app_id' => $app_id,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            Log::notice($message);
        }

        $api_url = 'https://api.houjin-bangou.nta.go.jp/4/diff'.
        '?id='. $app_id  // アプリケーションID
        . '&from=2022-01-26'
        . '&to=2022-01-26'
        . '&type=12' // Unicode
        ; 

        $response = Http::get($api_url);



        $xml_data = $response->body();

        $corporations = new  \SimpleXMLElement($xml_data);

        $message =
        [
          'function' => "TaxWebAPITestController.get1",
          'timing' => 'test1',
          'app_id' => $app_id,
          //'response' => $response,
          //'corporations' => $corporations,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            Log::notice($message);
        }

        for($i=1;$i<=$corporations->divideNumber;$i++){
            Log::notice($i);
            $api_url = 'https://api.houjin-bangou.nta.go.jp/4/diff'.
            '?id='. $app_id  // アプリケーションID
            . '&from=2022-01-26'
            . '&to=2022-01-26'
            . '&type=12' // Unicode
            . '&divide='. $i
            ; 
            $for_response = Http::get($api_url);
            $for_xml_data = $for_response->body();
    
            $for_corporations = new  \SimpleXMLElement($for_xml_data);    
            $this->parse_save($for_corporations);
        }

        return view('TaxWebAPI.index'); 
    }

    public function tgt_date_get(Request $request) {
        $app_id = config('app.TAX_AGENCY_APPLICATION_ID');

        $tgt_date = $request->date;

        $message =
        [
          'function' => "TaxWebAPITestController.tgt_date_get",
          'timing' => 'start function ',
          'app_id' => $app_id,
          'tgt_date' => $tgt_date,
          //'request' => $request,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            Log::notice($message);
        }

        $api_url = 'https://api.houjin-bangou.nta.go.jp/4/diff'.
        '?id='. $app_id  // アプリケーションID
        . '&from=' . $tgt_date
        . '&to=' . $tgt_date
        . '&type=12' // Unicode
        ; 
        $response = Http::get($api_url);
        $xml_data = $response->body();

        $corporations = new  \SimpleXMLElement($xml_data);

        $message =
        [
          'function' => "TaxWebAPITestController.tgt_date_get",
          'timing' => 'test1',
          'app_id' => $app_id,
          'api_url' => $api_url,
          'count' => $corporations->count,
          'divideNumber' => $corporations->divideSize,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            Log::notice($message);
        }

        for($i=1;$i<=$corporations->divideSize;$i++){
            $check_repeat_num = "Repeat_num:" . $i;
            Log::notice($check_repeat_num);
            $api_url = 'https://api.houjin-bangou.nta.go.jp/4/diff'.
            '?id='. $app_id  // アプリケーションID
            . '&from=' . $tgt_date
            . '&to=' . $tgt_date
            . '&type=12' // Unicode
            . '&divide='. $i
            ; 
            $for_response = Http::get($api_url);
            $for_xml_data = $for_response->body();
    
            $for_corporations = new  \SimpleXMLElement($for_xml_data);    
            $this->parse_save($for_corporations);
        }

        return view('TaxWebAPI.index'); 
    }


    private function parse_save($terget_bulk_corps) {
        
        foreach($terget_bulk_corps->corporation as $corp )
        {
            $n_check = true;
            $msg = "name:".$corp->name." corporateNumber:".$corp->corporateNumber;
            Log::notice($msg);
            try{
                $mod_corp =  new CompanyPublicInfo;
                $mod_corp->corporateNumber = $corp->corporateNumber ;
                $mod_corp->process = $corp->process ;
                $mod_corp->correct = $corp->correct ;
                $mod_corp->updateDate = $corp->updateDate ;
                $mod_corp->changeDate = $corp->changeDate ;
                $mod_corp->name = $corp->name;
                $mod_corp->kind = $corp->kind ;
                strlen($corp->prefectureName) ?  
                    ($mod_corp->prefectureName = $corp->prefectureName) : ($n_check = false) ;
                strlen($corp->cityName) ?  
                    ($mod_corp->cityName = $corp->cityName) : ($n_check = false) ;
                strlen($corp->cityName) ? 
                ($mod_corp->streetNumber = $corp->streetNumber) : ($n_check = false)  ;
                $mod_corp->prefectureCode = $corp->prefectureCode ;
                $mod_corp->cityCode = $corp->cityCode ;
                strlen($corp->postCode) ? 
                ($mod_corp->postCode = $corp->postCode) : ($n_check = false) ;
                $mod_corp->assignmentDate = $corp->assignmentDate ;
                $mod_corp->latest = $corp->latest ;
                $mod_corp->furigana = $corp->furigana ;
                $mod_corp->hihyoji = $corp->hihyoji ;

//                $n_check ? Log::notice("n_check:true") : Log::notice("n_check:false");

                if( ($corp->process == '01') && $n_check){
                    $mod_corp->save();    
                }
            }
            catch(\Excepiton $e){
                $message =
                [
                  'function' => "TaxWebAPITestController.get1",
                  'timing' => 'save',
                  'corporations' => $corporations,
                ];
                Log::error($message);
                Log::error($e);
            }
        }
        return;
    }

    /***
     * 
     * get infomation by the company number
     * 
     */
    public function compNo_comp_info(Request $request) {
        $app_id = config('app.TAX_AGENCY_APPLICATION_ID');

        $compNo = $request->compNo;

        $message =
        [
        'function' => "TaxWebAPITestController.compNo_comp_info",
        'timing' => 'start function ',
        'app_id' => $app_id,
        'compNo' => $compNo,
        //'request' => $request,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
        {
            //Log::notice($message);
        }

        $api_url = 'https://api.houjin-bangou.nta.go.jp/4/'
        .'num'
        .'?id='. $app_id  // アプリケーションID
        . '&number=' . $compNo
        . '&type=12' // Unicode
        . '&history=0' // no previous data
        ; 

        try{
            $response = Http::get($api_url);
        }
        catch(ConnectException $e){
                Log::error('Twitter API failed posting Tweet', [
                    'url' => $url,
                    'payload' => $payload,
                    'headers' => $headers,
                    'response' => $response->body(),
                    'exception' => $e,
                ]);
            
                $response->throw();
        }

        $xml_data = $response->body();

        $xml_elmnt = new  \SimpleXMLElement($xml_data);

        $message =
        [
          'function' => "TaxWebAPITestController.tgt_date_get",
          'timing' => 'after  parse response to xml',
          'api_url' => $api_url,
//          'response' => $response,
          'xml_elmnt' => $xml_elmnt,
//          'divideNumber' => $corporations->divideSize,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            Log::notice($message);
        }
        $search_corp_info = $xml_elmnt->corporation;
        $search_corp_num = $search_corp_info->corporateNumber;
        $search_corp_info_name = $search_corp_info->name;
        $search_key = array_search($search_corp_info->kind,array_column($this->comp_type,'id'));
        $search_corp_kind = $this->comp_type[$search_key]['def'];


        $message =
        [
          'function' => "TaxWebAPITestController.tgt_date_get",
          'timing' => 'after  get value',
          'search_corp_info' => $search_corp_info,
          'search_corp_info_name' => $search_corp_info_name,
          'search_corp_kind'=> $search_corp_kind,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            //Log::notice($message);
        }

        $cmpct = compact('search_corp_info_name', 'search_corp_info', 'search_corp_kind');

        return view('TaxWebAPI.corpNumInfo',$cmpct); 

         
    }



}