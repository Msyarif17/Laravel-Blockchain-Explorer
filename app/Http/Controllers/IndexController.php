<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use App\DataTables\TransactionsDataTable;

class IndexController extends Controller
{
    public function index(Datatables $datatables, Request $request){
        
            return view('index');

        
    }
    public function getTx(Datatables $datatables, Request $request){
        return $datatables->of(Transaction::query()->latest())
                ->addColumn('id', function (Transaction $transaction) {
                    return $transaction->id;
                })
                ->addColumn('sender', function (Transaction $transaction) {
                    return '0x'.Str::limit($transaction->sender,10);
                })
                ->addColumn('to', function (Transaction $transaction) {
                    return '0x'.Str::limit($transaction->to,10);
                })
                ->addColumn('amount', function (Transaction $transaction) {
                    return $transaction->amount;
                })
                ->addColumn('status', function (Transaction $transaction) {
                    return $transaction->isConfirmed ? 'Confirmed':'Unconfirmed';
                })
                ->addColumn('type', function (Transaction $transaction) {
                    return $transaction->isInput ? 'Input':'Output';
                })
                ->addColumn('created_at', function (Transaction $transaction) {
                    return $transaction->created_at;
                })
                ->make(true);
        
    }
    public function getBlock(Datatables $datatables, Request $request){
        return $datatables->of(Block::query()->latest())
                ->addColumn('index', function (Block $block) {
                    return $block->id;
                })
                ->addColumn('block', function (Block $block) {
                    return $block->nonce;
                })
                ->addColumn('hash', function (Block $block) {
                    return Str::limit($block->hash,10);
                })
                ->addColumn('created_at', function (Block $block) {
                    return $block->created_at;
                })
                ->make(true);
    }
}
 