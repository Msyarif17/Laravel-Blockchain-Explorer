<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $w = new WalletController;
        $address = "0x".Auth::user()->address;
        $balance = Auth::user()->balance;
        return view('home',compact('address','balance'));
    }
    public function send(){
        return view('wallet.send');
    }
    
}
