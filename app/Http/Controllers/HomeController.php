<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $watchlists = [];

        $companies = Company::with('latest_price')->get();

        if ($user) {
            $watchlists = auth()->user()->watchlists;
        }

        return view('welcome', compact('companies','watchlists'));
    }
}
