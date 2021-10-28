<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FlareAPIController extends Controller
{
    public function getBridgeWins($wallet)
    {
        $client = new Client();
        $api = env('FLARE_API_URL');
        $path = "/bridge/wins";
        $res = $client->post(
            $api . $path,
            ['json' => [
                'wallet_address' =>  $wallet
            ]]
        );
        return response()->json([
            'statusCode' => $res->getStatusCode(),
            'wins' => json_decode($res->getBody())
        ]);
    }
}