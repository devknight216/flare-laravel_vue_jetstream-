<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TokenRate;
use App\Events\UpdateRates;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function NodeCachePairs(Request $request)
    {
        $new_records = [];
        $time = time();
        foreach ($request->data as $set) {
            $pair = explode("-", $set['pair']);
            $rate = new TokenRate();
            $rate->pair = $set['pair'];
            $rate->supply_a = $set[$pair[0]];
            $rate->supply_b = $set[$pair[1]];
            $rate->price = $set['price'];
            $rate->datetime = $time;
            $rate->save();
            array_push($new_records, $rate);
        }
        $data = [
            'new_data' => true,
            'new_entries' => 0,
            'new_records' => $new_records
        ];
        UpdateRates::dispatch($data);
        return [
            'status' => 'ok',
            'error' => false,
            'result' => TokenRate::where('datetime', $time)->get()
        ];
    }
    public function getPairPrice(Request $request)
    {
        $items = [];
        $start_time = $request->start_time == 0 ? Carbon::now()->subDay(365) : Carbon::now()->subHours(24);

        $rate = TokenRate::where('pair', $request->pair)->where('datetime', '>', $start_time)->get();

        foreach ($rate as $item) {
            array_push($items, [
                'value' => (float)$item->price,
                'time' => (int)$item->datetime,
                'start' => $item->start_time,
            ]);
        }


        return $items;
    }
}