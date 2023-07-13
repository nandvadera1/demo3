<?php

use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTransactionController;
use App\Http\Controllers\VoucherBlockController;
use App\Http\Controllers\VouchersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');

Route::group(['prefix'=>'admin', 'middleware' => 'can:admin'],function (){
    Route::get('users/dataTable',[UserController::class,'dataTable']);
    Route::get('categories/dataTable',[CategoryController::class,'dataTable']);
    Route::get('products/dataTable', [ProductController::class, 'dataTable']);
    Route::get('campaigns/dataTable',[CampaignController::class,'dataTable']);
    Route::get('vouchers/dataTable',[VouchersController::class,'dataTable']);
    Route::get('transactions/dataTable',[AdminTransactionController::class,'dataTable']);
    Route::get('voucher_blocks/dataTable', [VoucherBlockController::class, 'dataTable']);

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::resource('vouchers', VouchersController::class);
    Route::resource('transactions', AdminTransactionController::class);
    Route::resource('voucher_blocks', VoucherBlockController::class);

    Route::get('transactions/points/{user}', [AdminTransactionController::class, 'points']);
    Route::get('voucher_blocks/download/{voucherBlock}', [VoucherBlockController::class, 'download']);
});

Route::group(['prefix'=>'user'],function (){
    Route::get('transactions/dataTable',[UserTransactionController::class,'dataTable']);
    Route::post('transactions/points', [UserTransactionController::class, 'scan']);

    Route::resource('transactions', UserTransactionController::class);
});

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth'])->name('verification.verify');
