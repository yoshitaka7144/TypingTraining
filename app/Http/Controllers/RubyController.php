<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * ルビ振りAPI呼び出しコントローラー
 */
class RubyController extends Controller
{
    /**
     * ふりがなとローマ字を取得
     *
     * @param Request $request
     * @return void
     */
    public function getRuby(Request $request)
    {
        $api_id = config("app.api_id");
        $url = "https://jlp.yahooapis.jp/FuriganaService/V2/furigana";

        $params = [
            "headers" => [
                "User-Agent" => "Yahoo AppID: " . $api_id,
            ],
            "json" => [
                "id" => "",
                "method" => "jlp.furiganaservice.furigana",
                "jsonrpc" => "2.0",
                "params" => [
                    "q" => $request->text
                ]
            ]
        ];

        $client = new Client();
        $response = $client->request("POST", $url, $params)->getBody()->getContents();

        return $response;
    }
}
