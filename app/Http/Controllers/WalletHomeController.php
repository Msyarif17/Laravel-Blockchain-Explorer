<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:wallet');
    }
    public function index()
    {
        return view('wallet.index');
    }
    
}
