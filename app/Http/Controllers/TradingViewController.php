<?php

namespace App\Http\Controllers;

use App\Models\TokenRate;
use Illuminate\Http\Request;

class TradingViewController extends Controller
{
    public function getHistory(Request $request)
    {
        $symbol = strtolower($request->input('symbol'));
        $from = $request->input('from');
        $to = $request->input('to');
        $resolution = $request->input('resolution');
        $countback = $request->input('countback');


        $items = TokenRate::where('pair', $symbol)->where('datetime', '>', $from)->where('datetime', '<', $to)->get();

        if (count($items) < 1) {
            $last = TokenRate::latest()->first();
            return [
                "s" => "no-data",
                'nextTime' => (int)$last->datetime
            ];
        }

        $t = [];
        $c = [];
        foreach ($items as $value) {
            array_push($t, (float)$value->datetime);
            array_push($c, (float)$value->price);
        }

        return [
            "s" => "ok",
            "t" => $t,
            "c" => $c
        ];
    }
    public function getSymbols(Request $request)
    {
        $symbol = $request->input('symbol');
        return [
            'name' => $symbol,
            'description' => 'Crypto',
            'exchange-listed' => 'X-FlareFinance',
            'exchange-traded' => 'X-FlareFinance',
            'has_intraday' => true,
            'has_no_volume' => true,
            'minmovement' => 1,
            'minmovement2' => 0,
            'pointvalue' => 1,
            'pricescale' => 100,
            'supported_resolutions' => ['1',],
            'ticker' => $symbol,
            'timezone' => 'America/California',
            'type' => 'crypto',

        ];
    }
    public function getTime()
    {
        return time();
    }
    public function getConfig()
    {
        return [
            "supported_resolutions" => ['1', '5', '15', '30', '60', '1D', '1W'],
            "supports_group_request" => false,
            "supports_marks" => false,
            "supports_search" => true,
            "supports_timescale_marks" => false,
        ];
    }
    public function getMarks(Request $request)
    {
        # code...
    }
    public function getTimescaleMarks(Request $request)
    {
        # code...
    }
    public function searchSymbol(Request $request)
    {
        $pairs =  TokenRate::select('pair')
            ->groupBy('pair')
            ->get();
        $search = [];
        foreach ($pairs as $pair) {
            array_push($search, [
                'symbol' => strtoupper($pair->pair),
                'full_name' => strtoupper($pair->pair),
                'description' => "",
                "eachange" => "X-FlareFinance",
                "type" => "FF Beta Token"
            ]);
        }

        return $search;
    }
}