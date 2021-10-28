<?php

namespace App\Http\Controllers;

use App\Models\Ftso;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index(Request $r)
    {
        $ftsos = Ftso::orderBy('id', 'desc')->where('verified', true)->get();

        return response()->view('sitemap', compact('ftsos'))
            ->header('Content-Type', 'text/xml');
    }
}