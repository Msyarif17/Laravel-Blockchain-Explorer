<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('nonce');
            $table->string('gasPrice');
            $table->string('gasLimit');
            $table->string('sender');
            $table->string('to');
            $table->string('token');
            $table->string('amount');
            $table->string('data');
            $table->boolean('isInput');
            $table->string('txHash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
