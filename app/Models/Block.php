<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;
    protected $fillable = [
        'index',
        'transaction_id',
        'nonce',
        'data',
        'previousHash',
        'hash',
    ];
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
