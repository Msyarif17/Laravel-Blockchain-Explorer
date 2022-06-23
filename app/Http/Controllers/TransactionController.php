<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use kornrunner\Ethereum\Token;
use kornrunner\Ethereum\Address;
use kornrunner\Ethereum\Token\USDT;
use Illuminate\Support\Facades\Auth;
use kornrunner\Ethereum\Transaction;
use App\Models\Transaction as Transaksi;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\BlockChainController;
use Illuminate\Contracts\Session\Session;

class TransactionController extends Controller
{
    public function index(){

    }
    public function create(){
        return view('wallet.send');
    }
    public function createTransaction(Request $request){
        $data['nonce']      = '04';
        $data['gasPrice']   = 40;
        $data['gasLimit']   = 21000;
        $data['to']         = $request->address;

        $privateKey = Auth::user()->private_key;
        $address = new Address($privateKey);
        $token = new Token;
        $usdt  = new USDT;
        $data['isInput']    = 0;
        $data['sender']     = $address->get();
        $data['amount']     = $request->amount;
        $data['amount']     = $this->calculateAmount($data['gasPrice'],$data['gasLimit'],$data['amount']);
        if($this->balanceCheck($data['amount'])){
            $hexAmount          = $token->hexAmount($usdt, $data['amount']);
    
            $data['data']       = $token->getTransferData($data['to'], $hexAmount);

            $transaction        = new Transaction($data['nonce'], $data['gasPrice'], $data['gasLimit'], $data['to'], '', $data['data']);
            $data['txHash']     = $transaction->getRaw($privateKey);
            $data['txHas']      = $transaction->getInput();
            Transaksi::create($data);

            return "Transaction Success";
        }
        return "Transaction Failed";
       
    }

    private function calculateAmount($gasPrice,$gasLimit,$amount){
        $gwei = $gasPrice*$gasLimit;
        $finalAmount = $amount-($gwei/10000000);
        return $finalAmount;
    }

    private function balanceCheck($amount){
        return Auth::user()->balace > $amount ? true:false;
    }

    public function calculateBalance($address){
        return Transaksi::where('sender',$address)->andWhere('isInput', 1)->sum('amount') - Transaksi::where('sender',$address)->andWhere('isInput', 0)->sum('amount');
    }
}
