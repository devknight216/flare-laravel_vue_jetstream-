<?php

use App\Events\UpdateRates;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Http\Request;
use Dotenv\Store\File\Reader;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\FlareAPIController;
use App\Http\Controllers\FTSOController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\TradingViewController;
use App\Http\Controllers\Web3Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Protected
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/list', [APIController::class, 'listDataProviders'])->middleware('throttle:120,1');
});


Route::prefix('ftso')->group(function () {
    Route::get('/list', [FTSOController::class, 'listFTSO'])->name('api.ftso.list')->middleware('throttle:60,1');
    Route::get('/single/{id}', [FTSOController::class, 'singleFTSO'])->name('api.ftso.single')->middleware('throttle:60,1');

    Route::get('/analytic', [AnalyticsController::class, 'getProivderSubmissionsFromEpoch'])->middleware('throttle:60,1');
    Route::get('/analytics-overview', [AnalyticsController::class, 'getProvidersOverview'])->middleware('throttle:60,1');
    Route::get('/provider-reward-state', [AnalyticsController::class, 'getRewardStateData'])->middleware('throttle:60,1')->name('api.provider.reward-state');
    Route::get('/network-statistics', [AnalyticsController::class, 'getNetworkStatistics'])->middleware('throttle:60,1')->name('api.network.statistics');

    // admin routes deprecated
    // Route::post('/create', [FTSOController::class, 'createFTSO'])->middleware('admin')->name('api.ftso.create');
    // Route::post('/update', [FTSOController::class, 'updateFTSO'])->middleware('admin')->name('api.ftso.update');
    // Route::get('/list-all', [FTSOController::class, 'listAllFTSO'])->middleware('admin')->name('api.ftso.listAll');
});

Route::prefix('twitter')->group(function () {
    Route::get('/user/{username}', [SocialController::class, 'getTwitterUserID'])->name('api.twitter.statistics')->middleware('throttle:25,1');
});
Route::prefix('youtube')->group(function () {
    Route::get('/channel/{channel_id}', [SocialController::class, 'getYoutubeChannelID'])->name('api.youtube.statistics')->middleware('throttle:25,1');
});

// Route::prefix('flare')->group(function () {
//     Route::get('/bridge/wins/{wallet}', [FlareAPIController::class, 'getBridgeWins'])->name('api.flare.bridgeWins');
// });