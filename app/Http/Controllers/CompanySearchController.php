<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CompanySearchController extends Controller
{
    //
    public function form() {

        return view('company_search.form');

    }

    public function search(Request $request) {

        $app_id = env('TAX_AGENCY_APPLICATION_ID');
        $company_name = urlencode($request->company_name);
        $api_url = 'https://api.houjin-bangou.nta.go.jp/4/name'.
            '?id='. $app_id . // アプリケーションID
            '&name='. $company_name . // URLエンコードした会社名（検索）
            '&change=1'. // 過去の情報も含める
            '&type=02'; // Unicode
        $response = Http::get($api_url);
        $csv_data = $response->body();

        $data = [];
        $loop = 0;
        $fp = tmpfile();
        fwrite($fp, $csv_data);
        fseek($fp, 0);

        while($company_data = fgetcsv($fp)) {

            if($loop > 0) {

                $data[] = [
                    'id' => $company_data[1], // 法人番号
                    'name' => $company_data[6], // 法人名,
                    'post_code' => $company_data[15], // 所在地（郵便番号）,
                    'prefecture' => $company_data[9], // 所在地（都道府県）,
                    'city' => $company_data[10], // 所在地（市区町村）,
                    'street' => $company_data[11], // 所在地（丁目番地等）,
                    'address' => $company_data[9] . $company_data[10] . $company_data[11]
                ];

            }

            $loop++;

        }

        return $data;

    }    
}
