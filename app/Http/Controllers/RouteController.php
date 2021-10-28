<?php

namespace App\Http\Controllers;

use App\Http\Traits\Web3Trait;
use App\Models\Ftso;
use App\Models\FtsoOwner;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    use Web3Trait;

    public function viewHome()
    {
        $title = "FlareMetrics | Accelerating The Network";
        $description = "Providing the community with valuable tools to help accelerate the growth of the platform.";
        $meta_image = env('CDN_URL') . '/meta-image.png';
        $meta_url = env('APP_URL') . '/';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('Home');
    }
    public function viewDashboard()
    {
        $title = "Flare FlareMetrics | Dashboard";
        $description = "Dashboard";
        $meta_image = env('CDN_URL') . '/flare/pages/yield-meta-image.png';
        $meta_url = env('APP_URL') . '/';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('Dashboard');
    }
    public function viewYieldCalculator()
    {
        $title = "Flare Finance Yield Calculator| FlareMetrics";
        $description = "Determine the expected earnings from a Flare Finance Farm pool by entering a few details and see how much YFIN you'll earn daily.";
        $meta_image = env('CDN_URL') . '/flare/pages/yield-meta-image.png';
        $meta_url = env('APP_URL') . '/yield-calculator';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('YieldCalculator')->withViewData(['title' => 'FF Yield Calculator | FlareMetrics']);
    }
    public function viewWalletCalculator()
    {
        $title = "Flare Finance Wallet Calculator | FlareMetrics";
        $description = "Quickly and easily calculate the value of your token holding in your Flare wallet usaing this easy wallet calculator.";
        $meta_image = env('CDN_URL') . '/flare/pages/walletcalc-meta-image.png';
        $meta_url = env('APP_URL') . '/wallet-calculator';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);

        $api = new APIController;
        return Inertia::render('WalletCalculator', [
            'statistics' => $api->getAllTokenStatistics()
        ])->withViewData(['title' => 'FF Wallet Calculator | FlareMetrics']);
    }
    public function viewBridgeWins()
    {
        $title = "Flare Bridge Wins | FlareMetrics";
        $description = "Find out how many wins you have gained through the bridge game (state connector system).";
        $meta_image = env('CDN_URL') . '/flare/pages/bridgewins-meta-image.png';
        $meta_url = env('APP_URL') . '/bridge-wins';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);

        return Inertia::render('BridgeWins')->withViewData(['title' => 'Flare Bridge Wins | FlareMetrics']);
    }

    public function viewOpenBetaSetup()
    {
        return Inertia::render('OpenBetaSetup');
    }

    public function viewFtso()
    {
        $title = "Flare Time Series Oracle (FTSO) List | FlareMetrics";
        $description = "Registered FTSO's (Flare Time Series Oracles) list on the Flare Network detailing the FTSO's website, social media and description. Find the location and details of each FTSO.";
        $meta_image = env('CDN_URL') . '/flare/pages/ftso-meta-image.png';
        $meta_url = env('APP_URL') . '/ftso';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('FTSO', ['provider_verified_count' => Ftso::where('verified', true)->count(), 'provider_count' => Ftso::count()]);
    }
    public function checkFtsoReward()
    {
        $title = "Check Reward | FlareMetrics";
        $description = "View your current FTSO Rewards";
        $meta_image = env('CDN_URL') . '/flare/pages/ftso-meta-image.png';
        $meta_url = env('APP_URL') . '/check-reward';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('CheckFtsoReward');
    }
    public function viewFtsoProviders($id)
    {
        if (strlen($id) > 6) {
            $ftso = Ftso::where('uid', $id)->first();
            if ($ftso == null) abort(404);
            if ($ftso->code) {
                return redirect()->route('view.providers', ['id' => $ftso->code])->setStatusCode(301);
            }
        } else {
            $ftso = Ftso::where('code', $id)->first();
        }



        $title = $ftso->name . " | Flare Time Series Oracle";
        $description = $ftso->site_description;
        $meta_image = $ftso->meta_image;
        $meta_url = env('APP_URL') . '/ftso/providers/' . $id;
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url,
        ]);
        return Inertia::render('FTSOProfile', [
            'code' => $id,
            'isOwner' => Auth::check() ? FtsoOwner::isOwner($ftso, Auth::user()) : false
        ]);
    }

    public function viewFtsoDemo()
    {
        $title = "FTSO Demo | FlareMetrics";
        $description = "Play around with the FTSO system setting your own parameters to gain a better understanding of how FTSO delegation works.";
        $meta_image = env('CDN_URL') . '/flare/pages/ftso-meta-image.png';
        $meta_url = env('APP_URL') . '/ftso';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('FTSODemo');
    }
    public function viewFtsoDemoV2()
    {
        $title = "FTSO Demo V2 | FlareMetrics";
        $description = "Play around with the FTSO system setting your own parameters to gain a better understanding of how FTSO delegation works.";
        $meta_image = env('CDN_URL') . '/flare/pages/ftso-meta-image.png';
        $meta_url = env('APP_URL') . '/ftso';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('FTSODemoV2');
    }

    public function viewPlayground()
    {
        // if (Auth::user()->email !== 'tim@onaxim.com') return;
        $title = "Playground";
        $description = "";
        $meta_image = env('CDN_URL') . '/flare/pages/ftso-meta-image.png';
        $meta_url = env('APP_URL') . '/';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('Playground');
    }

    public function viewFtsoLive()
    {
        // if (Auth::user()->email !== 'tim@onaxim.com') return;
        $title = "FTSO Live";
        $description = "";
        $meta_image = env('CDN_URL') . '/flare/pages/ftso-meta-image.png';
        $meta_url = env('APP_URL') . '/';
        Inertia::share([
            'title' => $title,
            'description' => $description,
            'meta_image' => $meta_image,
            'meta_url' => $meta_url
        ]);
        return Inertia::render('Premium/LiveDataProviderFeed');
    }
}