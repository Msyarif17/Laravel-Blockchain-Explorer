<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('index');
// Route::get('createWallet', [WalletController::class, 'createWallet']);

Auth::routes();
Route::prefix('wallet')->name('wallet.')->group(function (){
    Route::get('backup-private-key',[WalletController::class,'backup'])->name('backup');
    Route::post('/create-transaction', [TransactionController::class, 'createTransaction'])->name('create.transaction');

});
Route::prefix('blockchain')->name('blockchain.')->group(function (){
    Route::get('get-transaction-histories',[IndexController::class,'getTx'])->name('getTx');
    Route::get('get-block-histories',[IndexController::class,'getBlock'])->name('getBlock');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/send', [App\Http\Controllers\HomeController::class, 'send'])->name('send');


