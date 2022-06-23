<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use kornrunner\Ethereum\Address;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction as Transaksi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WalletController extends Controller
{

    public function send(){
        return view('wallet.send');
    }
    public function backup(){
        $pk = Auth::user()->private_key;
        return view('wallet.backup',compact('pk'));
    }
    public function calculateBalance($address){
        return Transaksi::where('sender',$address)->andWhere('isInput', 1)->sum('amount') - Transaksi::where('sender',$address)->andWhere('isInput', 0)->sum('amount');
    }
}
