<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeatureInviteCode;
use Illuminate\Support\Facades\Auth;

class FeatureInviteCodeController extends Controller
{
    public function requestCode(Request $request)
    {
        $feature = $request->input('feature');
        $features = ["rewards"];

        if (!in_array($feature, $features)) {
            return [
                'error' => true,
                'errors' => ['Feature does not exist']
            ];
        }

        if (FeatureInviteCode::where('user_id', Auth::id())->where('feature', $feature)->count()) {
            return [
                'error' => true,
                'errors' => ['You already have a code.']
            ];
        }

        // Generate Code
        $code = new FeatureInviteCode();
        $code->user_id = Auth::id();
        $code->feature = $feature;
        $code->max_redemptions = 2;
        $code->expiry = Carbon::now()->addWeeks(52);
        $code->save();

        return $code;
    }
}