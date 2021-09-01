<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RomanController extends Controller
{
    public function index(Request $request)
    {
        $api_id = "dj00aiZpPVBuM3ptSVI4bHoyaiZzPWNvbnN1bWVyc2VjcmV0Jng9Nzg-";
        $url = "https://jlp.yahooapis.jp/FuriganaService/V1/furigana?appid=".$api_id."&sentence=".$request->text;

        //接続
        $client = new Client();

        $response = $client->request("POST", $url);
        $posts = $response->getBody();

        return $posts;
    }
}
