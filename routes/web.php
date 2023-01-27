<?php

use App\Http\Controllers\Enterprise\AccountSetupController;
use App\Http\Controllers\General\ContactController;
use App\Http\Controllers\General\HomeController;
use App\Http\Controllers\General\NewsController;
use App\Http\Controllers\General\PaymentController;
use App\Http\Controllers\General\ReportBugController;
use App\Http\Controllers\MainController;
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

Route::resource('/', MainController::class);
//Do not require authentication
Route::group([], function (){
    Route::resource('contact-us',ContactController::class);
    Route::resource('report-bug',ReportBugController::class);
});

Route::group(['middleware'=>['auth:web']],function (){
    Route::get('payments/callback/{id}',[PaymentController::class, 'callback'])->name('callback');
    Route::resource('payments',PaymentController::class);
    Route::resource('news',NewsController::class);
    Route::resource('home',HomeController::class);
});


require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
require __DIR__.'/enterprise.php';
require __DIR__.'/account.php';
