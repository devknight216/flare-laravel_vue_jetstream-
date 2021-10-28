<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\TokenRate;
use App\Models\ChartImage;
use App\Events\UpdateRates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StatisticCache;
use App\Models\Ftso;
use Illuminate\Support\Facades\Validator;
use Spatie\ValidationRules\Rules\Delimited;

class APIController extends Controller
{
    public function listDataProviders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fields' => [(new Delimited('String', ['fields.string' => "Must Specify Items"]))->min(1)],
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return ['error' => false, 'message' => $error];
        }

        $fields = explode(',', $request->input('fields'));

        // Filter restricted field out
        $hidden_fields = ['id', 'admin_email', 'meta_image', 'site_description', ''];
        $filtered_fields = array_filter($fields,  function ($field) use ($hidden_fields) {
            if (in_array($field, $hidden_fields)) {
                return false;
            }
            return true;
        });

        $data_providers = Ftso::select($filtered_fields)->get();


        return ['error' => false, 'message' => $data_providers];
    }
}