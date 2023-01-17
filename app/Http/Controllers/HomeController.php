<?php

namespace App\Http\Controllers;

use App\Services\MarketService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MarketService $marketService)
    {
        $this->middleware('auth');

        parent::__construct($marketService);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    /**
     * Show the purchases of the user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPurchases(Request $request)
    {
        //
    }
    
    /**
     * Show the products of the user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showProducts(Request $request)
    {
        //
    }
}
