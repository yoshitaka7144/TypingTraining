<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RomanController extends Controller
{
    public function index(Request $request)
    {
        $api_id = "dj00aiZpPVBuM3ptSVI4bHoyaiZzPWNvbnN1bWVyc2VjcmV0Jng9Nzg-";
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
