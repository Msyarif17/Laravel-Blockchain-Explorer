<?php

namespace App\Models;

use App\Models\Block;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'nonce',
        'gasPrice',
        'gasLimit',
        'sender',
        'to',
        'token',
        'amount',
        'data',
        'isInput',
        'isConfirmed',
        'txHash',
    ];
    public function block(){
        return $this->hasMany(Block::class);
    }
}
