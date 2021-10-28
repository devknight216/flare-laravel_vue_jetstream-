<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Ftso;
use App\Models\Analytic;
use App\Models\FeatureInviteCode;
use App\Models\FtsoOwner;
use App\Models\FtsoUserRewardState;
use App\Models\FtsoUserTracking;
use App\Models\NetworkStatistic;
use App\Models\ProviderPool;
use Illuminate\Http\Request;
use App\Models\ProviderSubmission;
use Illuminate\Support\Facades\DB;
use App\Models\ProviderRewardState;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Web3\Net;

class AnalyticsController extends Controller
{
    public function getFTSOAnalytics(Request $request)
    {
        $app_url = 'https://flaremetrics.io';
        $page = "{$app_url}/ftso/providers/{$request->ftso_code}";

        if (!FtsoOwner::isOwner(Ftso::where('code', $request->ftso_code)->first(), Auth::user())) {
            return [
                'error' => true,
                'message' => 'Access Denied'
            ];
        }

        $model = Analytic::where('period', $request->input('period'))->first();
        if ($model) {
            if (Carbon::parse($model->updated_at) < Carbon::now()->subMinutes(3)) {
                $model = $model->updateAnalytics($request->input('period'));
            }
        } else {
            $model = new Analytic();
            $model->updateAnalytics($request->input('period'));
        }

        $data = Analytic::where('period', $request->input('period'))->select(
            "click->{$page} as click",
            "page_view->{$page} as page_view",
            "user_engagement->{$page} as user_engagement"
        )->get();
        return $data;
    }
    public function getProivderSubmissionsFromEpoch(Request $request)
    {
        $provider_address = $request->input('provider_address');
        $from_epoch = $request->input('from_epoch');
        $token = $request->input('token');

        if ($provider_address == null) {
            return 'error';
        }

        $submission = new ProviderSubmission();

        $submissions = $submission->where('epoch_id', '>', $from_epoch)->where('token', $token)->where('provider_address', $provider_address)->get();

        return $submissions;
    }
    public function getProivderDaySubmissions(Request $request)
    {
        $provider_address = $request->input('provider_address');
        $current_epoch = $request->input('current_epoch');
        $from_epoch = $current_epoch - 160;
        $token = $request->input('token');

        if ($provider_address == null) {
            return 'error';
        }

        $submission = new ProviderSubmission();

        $submissions = $submission->where('epoch_id', '>', $from_epoch)->where('token', $token)->where('provider_address', $provider_address)->get();
        // return $submissions;
        $totalRounds = count($submissions);
        $totalNonZeroSubmissions = 0;
        $epochsMissingData = [];
        foreach ($submissions as $round) {
            if ($round->submission !== 0) {
                $totalNonZeroSubmissions++;
            } else {
                array_push($epochsMissingData, $round->epoch_id);
            }
        }

        return [
            'from_epoch' => $from_epoch,
            'total_rounds' => $totalRounds,
            'total_non_zero_submissions' => $totalNonZeroSubmissions,
            'epochs_missing_data' => $epochsMissingData,
            'sample' => $submissions[0]
        ];
    }
    public function getProvidersOverview(Request $request)
    {
        $ftsos = [
            "0xa1a9b8ab5bb798eee536a23669ad744dcf8537a3",
            "0x157d6316475765f13348dfa897c503af0161b232",
            "0xdc2cfeee7da8be3eef13b9e05bb4235063d0ecc1",
            "0xbc696a456e351c8a5f170135868a3850eb29135a",
            "0xce7472a48754a2afe34951c6f35f7bfe01bb8fee",
            "0x2ce1d8653bbca3f636a63e35136f4e015f0b4647",
            "0x9dcda46cb0589ec54384801905b2f79b65e93347",
            "0xd47b92e53941b7f71aca3cd6235c866c55b4f23a",
            "0x20fecb7b1ff69c62bba5bb6acd5a9743d11e246f",
            "0x3c028fe13a87229d5d56a5b234edc0199794684e",
            "0x71c57de677222f5e9bb3a3134eb27aee8b50bd39",
        ];
        $indicies = [
            "XRP", "LTC", "XLM", "DOGE", "ADA", "ALGO", "BCH", "DGB", "BTC", "ETH", "FIL",
        ];

        $proivder_pools = ProviderPool::where('network', 'songbird')->where('votepower', '>', 0)->get();

        $current_epoch = $request->input('current_epoch');
        $from_epoch = $current_epoch - 160;

        $data = [];

        foreach ($proivder_pools as $provider) {

            foreach ($ftsos as $ftso_index =>  $ftso) {
                $result = $this->getProviderStatistics($provider->provider_name, $provider->address, $from_epoch, $ftso);
                array_push($data, $result);
            }
        }
        $provider_data = [];
        foreach ($data as $round) {
            unset($round['epochs_missing_data']);
            $provider_data[$round['provider_address']]['ftso_submissions'][] = $round;
        }

        foreach ($provider_data as $key => $data) {
            $total_rounds = 0;
            $total_missed_rounds = 0;
            // Log::debug($data);

            foreach ($data['ftso_submissions'] as $submission) {
                $total_rounds += $submission['total_rounds'];
                $total_missed_rounds += $submission['total_missed_rounds'];
            }
            $provider_data[$key]['total_missed_rounds'] = $total_missed_rounds;
            $provider_data[$key]['total_rounds'] = $total_rounds;
            $missed_percentage = ($total_missed_rounds / $total_rounds) * 100;
            $provider_data[$key]['submission_ratio'] = 100 - $missed_percentage;
        }





        return [
            'assessed_duration_hours' => (((int)$current_epoch - (int)$from_epoch) * 4.5) / 60,
            'to_epoch' => (int)$current_epoch,
            'from_epoch' => (int)$from_epoch,
            'submission_data' => $provider_data
        ];
    }
    public function getProviderStatistics($provider_name, $provider_address, $from_epoch, $ftso)
    {
        if ($provider_address == null) {
            return 'error';
        }


        $submission = new ProviderSubmission();

        $submissions = $submission->where('epoch_id', '>', $from_epoch)->where('token_address', $ftso)->where('provider_address', $provider_address)->get();
        $token = $submissions[0]->token;
        $totalRounds = count($submissions);
        $totalNonZeroSubmissions = 0;
        $epochsMissingData = [];
        foreach ($submissions as $round) {
            if ($round->submission !== 0) {
                $totalNonZeroSubmissions++;
            } else {
                array_push($epochsMissingData, $round->epoch_id);
            }
        }

        return [
            'token' => $token,
            'ftso' => $ftso,
            'provider_name' => $provider_name,
            'provider_address' => $provider_address,
            'from_epoch' => $from_epoch,
            'total_rounds' => $totalRounds,
            'total_non_zero_submissions' => $totalNonZeroSubmissions,
            'total_missed_rounds' => $totalRounds - $totalNonZeroSubmissions,
            'epochs_missing_data' => $epochsMissingData,
        ];
    }

    public function getRewardStateData(Request $request)
    {
        $providerId = $request->input('provider_id');
        $data = [];
        $group = ProviderRewardState::orderBy('created_at', 'desc')->where('provider_id', $providerId)->where('created_at', ">", Carbon::now()->subDays(7))->get()->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d h');
        });

        foreach ($group as $item) {
            $object = [
                'provider_reward_state' => $item->max()->provider_reward_state,
                'provider_votepower' => $item[0]->provider_votepower,
                'provider_fee' => $item[0]->provider_fee,
                'reward_epoch' => $item[0]->reward_epoch,
                'created_at' => date("Y-m-d H:00:00", strtotime($item[0]->created_at))
            ];
            array_push($data, $object);
        }
        return $data;
    }

    public function getNetworkStatistics()
    {
        $songbirdStatistics = NetworkStatistic::where('network', 'songbird')->first();
        $flareStatistics = NetworkStatistic::where('network', 'flare')->first();

        return ['songbird_statistics' => $songbirdStatistics, 'flare_statistics' => $flareStatistics];
    }

    public function getUserRewardState(Request $request)
    {
        $address = $request->input('address');

        if (FtsoUserTracking::where('address', $address)->where('user_id', Auth::id())->count() == 0) {
            return ['error' => true, 'message' => 'Not your tracking address'];
        }



        $current_epoch = $request->input('current_epoch');
        $chart_data = FtsoUserRewardState::where('updated_at', ">", Carbon::now()->subDays(7))->orderBy('updated_at', 'desc')->where('address', $address)->select(['day_rewards', 'epoch_rewards', 'epoch_id', 'updated_at'])->get();
        $latest_epoch = FtsoUserRewardState::where('epoch_id', $current_epoch)->where('address', $address)->orderBy('updated_at', 'desc')->first();
        $previous_epoch =
            FtsoUserRewardState::where('epoch_id', $current_epoch - 1)->where('address', $address)->orderBy('updated_at', 'desc')->first();

        $epoch_group = FtsoUserRewardState::orderBy('updated_at', 'desc')->where('address', $address)->get()->groupBy(function ($item) {
            return $item->epoch_id;
        });

        $previous_epoch_provider_reward_states = [];

        if ($previous_epoch !== null) {
            if ($previous_epoch->provider_id_2) {
                array_push($previous_epoch_provider_reward_states, ProviderRewardState::where('provider_id', $previous_epoch->provider_id_1)->where('reward_epoch', $current_epoch - 1)->orderBy('updated_at', 'desc')->first());
            }
            if ($previous_epoch->provider_id_2) {
                array_push($previous_epoch_provider_reward_states, ProviderRewardState::where('provider_id', $previous_epoch->provider_id_2)->where('reward_epoch', $current_epoch - 1)->orderBy('updated_at', 'desc')->first());
            }
        }

        $current_reward_sum = 0;
        foreach ($epoch_group as $item) {
            $current_reward_sum += $item[0]->epoch_rewards;
        }

        if (!FeatureInviteCode::where("user_id", Auth::id())->where("feature", 'rewards')->count()) {
            $invite = FeatureInviteCode::generateInvite(Auth::id(), 'rewards', 2);
        } else {
            $invite = FeatureInviteCode::where("user_id", Auth::id())->where("feature", 'rewards')->first();
        }


        return [
            "latest_epoch" => $latest_epoch,
            "previous_epoch" => $previous_epoch,
            'chart_data' => $chart_data,
            'address' => $address,
            'total_earnings' => $current_reward_sum,
            'previous_provider_reward_states' => $previous_epoch_provider_reward_states,
            'invite' => $invite
        ];
    }
    public function trackUserAddress(Request $request)
    {

        $trackingsLimit = env('TRACKING_ADDRESSES_ALLOWED');
        $userTrackings = FtsoUserTracking::where('user_id', Auth::id())->get();
        $invite_code = $request->input('invite_code');

        if ($request->input('address') == null || $request->input('address') == "") {
            return ['error' => true, 'errors' => ['Please enter a valid address.']];
        }
        if ($userTrackings->count() > 0) {
            return ['error' => true, 'errors' => ['One tracking address per user limit reached.']];
        }

        if ($invite_code == null || $invite_code == "") {
            return ['error' => true, 'errors' => ['Please enter a valid invite code.']];
        }

        $invite = FeatureInviteCode::where('code', $invite_code)->first();
        if (!$invite) {
            return ['error' => true, 'errors' => ['Invalid invite code.']];
        }
        if ($invite->redemptions >= $invite->max_redemptions) {
            return ['error' => true, 'errors' => ['Invite code max redemptions reached.']];
        }


        $trackingsCount = FtsoUserTracking::count();
        if ($trackingsCount >= $trackingsLimit) {
            return ['error' => true, 'errors' => ['Tracking limit reached, try again later.']];
        }

        if (FtsoUserTracking::where('user_id', Auth::id())->where('address', $request->input('address'))->count()) {
            return ['error' => true, 'errors' => ['Already tracking this address.']];
        }
        // if (!ProviderPool::where('address', $request->input('address'))->count()) {
        //     return ['error' => true, 'errors' => ['Only providers listed on Flare Metrics allowed.']];
        // }

        $invite->redemptions++;
        $invite->save();


        $userTracking = new FtsoUserTracking();
        $userTracking->address = strtolower($request->input('address'));
        $userTracking->user_id = Auth::id();
        $userTracking->save();
        return [
            'error' => false,
            'message' => 'Address now being tracked...'
        ];
    }
    public function getUserTrackingAddresses()
    {
        return FtsoUserTracking::where('user_id', Auth::id())->get();
    }
}

// [
//             "latest_epoch" => [
//                 'address' => null,
//                 'epoch_id' => null,
//                 'epoch_rewards' => null,
//                 'day_rewards' => null,
//                 'provider_id_1' => null,
//                 'provider_percentage_1' => null,
//                 'provider_claimed_1' => null,
//                 'provider_id_2' => null,
//                 'provider_percentage_2' => null,
//                 'provider_claimed_2' => null,
//                 'claimable' => null
//             ],
//             "previous_epoch" => [
//                 'address' => null,
//                 'epoch_id' => null,
//                 'epoch_rewards' => null,
//                 'day_rewards' => null,
//                 'provider_id_1' => null,
//                 'provider_percentage_1' => null,
//                 'provider_claimed_1' => null,
//                 'provider_id_2' => null,
//                 'provider_percentage_2' => null,
//                 'provider_claimed_2' => null,
//                 'claimable' => null
//             ],