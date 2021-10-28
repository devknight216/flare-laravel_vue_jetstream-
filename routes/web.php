<?php

use App\Models\Ftso;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\FeatureInviteCodeController;
use App\Http\Controllers\FtsoApplicationsController;
use App\Http\Controllers\FTSOController;
use App\Models\FtsoApplication;
use App\Models\FtsoOwner;
use App\Notifications\ProviderApplicationSubmitted;
use App\Notifications\ProviderUpdateApplicationResult;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Adapter\Ftp;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/notif', function () {
    $application = FtsoApplication::find(31);

    return (new ProviderUpdateApplicationResult($application))
        ->toMail($application);
});

Route::get('/', [RouteController::class, 'viewHome'])->name('view.home');

Route::get('sitemap.xml', [SitemapController::class, 'index']);

Route::get('/yield-calculator', [RouteController::class, 'viewYieldCalculator'])->name('view.yield-calculator');

Route::get('/wallet-calculator', [RouteController::class, 'viewWalletCalculator'])->name('view.wallet-calculator');

Route::get('/ftso', [RouteController::class, 'viewFtso'])->name('view.ftso');

Route::get('/check-reward', [RouteController::class, 'checkFtsoReward'])->name('view.check-ftso-reward');

Route::get('/ftso/providers/{id}', [RouteController::class, 'viewFtsoProviders'])->name('view.providers');

Route::get('/ftso-demo', [RouteController::class, 'viewFtsoDemo'])->name('view.ftso-demo');

Route::get('/ftso-demo-v2', [RouteController::class, 'viewFtsoDemoV2'])->name('view.ftso-demoV2');

Route::get('/playground', [RouteController::class, 'viewPlayground'])->name('view.playground');

Route::post('/submit/ftso-application', [FtsoApplicationsController::class, 'submitApplication'])->name('ftso.application');

Route::get('/provider/image/emblem/{address}', [FTSOController::class, 'getProviderEmblem']);


// TODO: Remove route
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [RouteController::class, 'viewDashboard'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/ftso-analytics', [AnalyticsController::class, 'getFTSOAnalytics'])->name('analytics.ftso');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // Route::get('/invite/feature', [FeatureInviteCodeController::class, 'requestCode'])->name('user.invite.feature');
        Route::prefix('/ftso/tracking')->group(function () {
            Route::get('/addresses', [AnalyticsController::class, 'getUserTrackingAddresses'])->name('user.ftso.tracking.addresses');
            Route::post('/add', [AnalyticsController::class, 'trackUserAddress'])->name('user.ftso.tracking.add');
            Route::get('/', [AnalyticsController::class, 'getUserRewardState'])->name('user.ftso.tracking');
        });

        Route::get('/ftso-live', [RouteController::class, 'viewFtsoLive'])->name('view.ftso-live');

        // Provider Manage Listing View
        Route::group(['prefix' => 'provider'], function () {
            Route::get('/manage/{code}', function ($code) {
                $ftso = Ftso::where('code', $code)->first();
                if (!FtsoOwner::isOwner($ftso, Auth::user())) {
                    return Redirect('/');
                }
                return Inertia::render('Provider/ManageProvider', ['code' => $code]);
            })->name('view.provider.manage');

            // Provider Update Listing View
            Route::get('/update/{code}', function ($code) {
                $ftso = Ftso::where('code', $code)->first()->makeVisible('admin_email');
                if (!FtsoOwner::isOwner($ftso, Auth::user())) {
                    return Redirect('/');
                }
                return Inertia::render('Provider/UpdateProvider', ['code' => $code, 'provider' => $ftso]);
            })->name('view.provider.update');

            // Provider Register Listing View
            Route::get('/register', function () {
                return Inertia::render('Provider/RegisterProvider');
            })->name('view.provider.register');

            // Provider Get FTSO Applications
            Route::get('/get-applications', [FtsoApplicationsController::class, 'getApplications'])->name('get.provider.applications');

            // Provider Get Pools
            Route::get('/get-provider-pools', [FTSOController::class, 'getProviderPools'])->name('get.provider.pools');

            // Provider Create Pools
            Route::post('/create-provider-pool', [FTSOController::class, 'createProviderPool'])->name('action.provider.create-pool');
        });
    }
);

Route::middleware(['auth:sanctum', 'admin', 'verified'])->group(function () {
    Route::get('/admin/ftso-manager', function () {
        return Inertia::render('Admin/FTSOManager');
    })->name('admin.ftso-manager');
    Route::get('/admin/ftso-manager/manual', function () {
        return Inertia::render('Admin/ManualFtsoModify');
    })->name('admin.ftso-manager.manual');

    Route::get('/get-provider-pools-paginate', [FTSOController::class, 'getProviderPoolsPaginate'])->name('admin.get.provider.pools');

    Route::post('/approve-provider-pool', [FTSOController::class, 'approveProviderPool'])->name('admin.approve.provider.pool');

    Route::get('/admin/ftso-manager/get-applications', [FtsoApplicationsController::class, 'getApplicationsPaginate'])->name('action.admin.get-applications');

    Route::post('/admin/ftso-manager/create-from-application', [FtsoApplicationsController::class, 'createProviderFromApplication'])->name('admin.create-from-application');

    Route::post('/admin/ftso-manager/update-from-application', [FtsoApplicationsController::class, 'updateProviderFromApplication'])->name('admin.update-from-application');

    Route::post('/admin/ftso-manager/reject-application', [FtsoApplicationsController::class, 'rejectApplication'])->name('admin.reject-application');

    Route::get('/admin/ftso-manager/assess/{id}', function ($id) {
        $application = FtsoApplication::find($id);
        return Inertia::render('Admin/AssessApplication', ['id' => $id, 'application' => $application]);
    })->name('admin.assess-applications');

    // Preview Mail Notification
    // Route::get('mail-preview', function () {
    //     $app = FtsoApplication::where("id", '4')->first();
    //     return (new ProviderUpdateApplicationResult($app))->toMail(Auth::id(1));
    // });
});


// **********************************************
//          ** DEPRECATED ROUTES **
// **********************************************

//datafeeds/udf/dist/bundle.js

// http://localhost/charting_library/charting_library.standalone.js
// Route::get('/scrape/snapshot/{token}', [ChartController::class, 'snapshotChart'])->name('data.snapshot.chart');

// Route::get('/bridge-wins', [RouteController::class, 'viewBridgeWins'])->name('view.bridge-wins');


// Route::get('/validate-nft', [RouteController::class, 'viewValidateNFT'])->name('view.validate-nft');

// Route::get('/charts', [RouteController::class, 'viewChartsHome'])->name('view.charts');

// Route::get('/charts/{pair}', [RouteController::class, 'viewPairChart'])->name('view.charts.pair');

// Route::get('/grid/charts/', [RouteController::class, 'viewGridCharts'])->name('view.charts.grid');

// Route::get('/open-beta-setup', [RouteController::class, 'viewOpenBetaSetup'])->name('view.open-beta-setup');

// Route::middleware('iframe')->get('/charts/embed/{pair}', [RouteController::class, 'viewEmbedChart', 'nocsrf' => true])->name('view.embed.charts');
