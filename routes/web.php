<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [TransactionController::class, 'createTransaction']);
Route::get('createWallet', [WalletController::class, 'createWallet']);

Auth::routes();
Route::prefix('wallet')->name('wallet.')->group(function (){
    Route::get('backup-private-key',[WalletController::class,'backup'])->name('backup');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
