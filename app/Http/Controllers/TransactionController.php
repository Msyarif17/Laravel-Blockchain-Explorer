<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Wallet;
use Illuminate\Http\Request;
use kornrunner\Ethereum\Token;
use kornrunner\Ethereum\Address;
use kornrunner\Ethereum\Token\USDT;
use Illuminate\Support\Facades\Auth;
use kornrunner\Ethereum\Transaction;
use App\Models\Transaction as Transaksi;
use App\Http\Controllers\BlockController;
use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\BlockChainController;
use App\Models\Block;

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
        $data['to']         = substr($request->to,2);

        $privateKey = Auth::user()->private_key;
        $address = new Address($privateKey);
        $token = new Token;
        $usdt  = new USDT;
        $data['isInput']    = 0;
        $data['sender']     = $address->get();

        $data['amount']     = (int)$request->amount ;
        
        if($this->balanceCheck($data['amount'])){
            $hexAmount          = $token->hexAmount($usdt, $data['amount']);
    
            $data['data']       = $token->getTransferData($data['to'], $hexAmount);
            // dd($data);
            $transaction        = new Transaction(str($data['nonce']), str($data['gasPrice']), str($data['gasLimit']), str($data['to']), '', $data['data']);
            $data['txHash']     = $transaction->getRaw($privateKey);
            $data['token']      = 'USDT';
            $sender = Wallet::where('address',$data['sender'])->firstOrFail();
            $sender->balance = $this->calculateBalance($data['sender'],(int)$request->amount,false);
            $sender->save();
            // dd($sender);
            Transaksi::create($data);
            $block = $this->validator($transaction->getInput());

            $data['isInput']    = 1;
            $data['amount']     = (int)$request->amount - $this->calculateGwei($data['gasPrice'],$data['gasLimit'],(int)$request->amount);
            
            Transaksi::create($data);
            
            
            if(Wallet::where('address',$data['to'])->count()>0){
                $receiver = Wallet::where('address',$data['to'])->first();
                
                $receiver->balance = $this->calculateBalance($data['to'],$data['amount'],true);
                
                $receiver->save();
                dd($receiver);
            }
            
            
            $block = $this->validator($transaction->getInput());
            
            return redirect()->to('home')->with('status',"Transaction Success");
        }
        return redirect()->route('home')->with('status',"Transaction Failed");
       
    }
   

    private function calculateGwei($gasPrice,$gasLimit,$amount){
        $gwei = $gasPrice*$gasLimit;
        $finalGwei = $gwei/10000000;
        return $finalGwei;
    }

    private function balanceCheck($amount){
        return Auth::user()->balance > $amount ? true:false;
    }

    public function calculateBalance($address,$amount,$isInput){
        // dd( Wallet::where('address',$address)->get()->count()>0);
        if(Transaksi::all()->count() > 0 && Wallet::where('address',$address)->get()->count()>0 && $isInput){ 
            
                $balance = Wallet::where('address',$address)->first()->balance + Transaksi::where('to',$address)->where('isInput',1)->latest()->first()->amount;
                return $balance;
            
        }
        else{
            return Wallet::where('address',$address)->firstOrFail()->balance - $amount;
        }
        
    }

    public function validator($data){
        $validator = new BlockChainController();
        for($i=1;$i<=4;$i++){
            $validator->push(new BlockController($i,Carbon::now(),implode($data)));
            $data['index'] = $validator->chain[$i-1]->index;
            $data['transaction_id'] = Transaksi::latest()->first()->id;
            $data['nonce'] = $validator->chain[$i-1]->nonce;
            $data['data'] = $validator->chain[$i-1]->data;
            $data['previousHash'] = $validator->chain[$i-1]->previousHash;
            $data['hash'] = $validator->chain[$i-1]->hash;
            Block::create($data);
        }
        $trans = Transaksi::findOrFail(Transaksi::latest()->first()->id);
        $trans->isConfirmed = $validator->isValid();
        $trans->save();
        
        return true;
    }
}
