<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TaxWebAPITestController extends Controller
{
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
//          'app_id' => $rate['mailPerMinute'],
          'app_id' => $app_id,
//          'request' => $request,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            Log::notice($message);
        }

        $api_url = 'https://api.houjin-bangou.nta.go.jp/4/diff'.
        '?id='. $app_id . // アプリケーションID
        '&from=2022-01-26'.
        '&to=2022-01-26'.
        '&change=1'. // 過去の情報も含める
        '&type=12'; // Unicode
        $response = Http::get($api_url);
        $xml_data = $response->body();

        //$xml_data = '<?xml version="1.0" encoding="UTF-8"?><corporations><lastUpdateDate>2022-02-03</lastUpdateDate><count>2843</count><divideNumber>1</divideNumber><divideSize>2</divideSize><corporation><sequenceNumber>1</sequenceNumber><corporateNumber>1010001012570</corporateNumber><process>21</process><correct>0</correct><updateDate>2022-01-26</updateDate><changeDate>2022-01-19</changeDate><name>三井物産グローバル投資株式会社</name><nameImageId/><kind>301</kind><prefectureName>東京都</prefectureName><cityName>千代田区</cityName><streetNumber>大手町１丁目２番１号三井物産ビル２６Ｆ</streetNumber><addressImageId/><prefectureCode>13</prefectureCode><cityCode>101</cityCode><postCode>1000004</postCode><addressOutside/><addressOutsideImageId/><closeDate>2022-01-19</closeDate><closeCause>01</closeCause><successorCorporateNumber/><changeCause/><assignmentDate>2015-10-05</assignmentDate><latest>1</latest><enName/><enPrefectureName/><enCityName/><enAddressOutside/><furigana>ミツイブッサングローバルトウシ</furigana><hihyoji>0</hihyoji></corporation><corporation><sequenceNumber>2</sequenceNumber><corporateNumber>1010001040308</corporateNumber><process>01</process><correct>1</correct><updateDate>2022-01-26</updateDate><changeDate>2015-10-05</changeDate><name>株式会社カント不動産</name><nameImageId/><kind>301</kind><prefectureName>東京都</prefectureName><cityName>中央区</cityName><streetNumber>日本橋中洲６番１３号</streetNumber><addressImageId/><prefectureCode>13</prefectureCode><cityCode>102</cityCode><postCode>1030008</postCode><addressOutside/><addressOutsideImageId/><closeDate/><closeCause/><successorCorporateNumber/><changeCause/><assignmentDate>2015-10-05</assignmentDate><latest>1</latest><enName/><enPrefectureName/><enCityName/><enAddressOutside/><furigana>カントフドウサン</furigana><hihyoji>0</hihyoji></corporation></corporations>';

        $corporations = new  \SimpleXMLElement($xml_data);

        $message =
        [
          'function' => "TaxWebAPITestController.get1",
          'timing' => 'test1',
//          'app_id' => $rate['mailPerMinute'],
          'app_id' => $app_id,
          'corporations' => $corporations,
        ];

        if (env('APP_ENV') <> 'production'&&config('app.env')<>'production')
         {
            Log::notice($message);
        }


        return view('TaxWebAPI.index');
    }

}
