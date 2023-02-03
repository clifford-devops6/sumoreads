<?php

use App\Http\Controllers\Enterprise\AccountSetupController;
use App\Http\Controllers\General\ContactController;
use App\Http\Controllers\General\HomeController;
use App\Http\Controllers\General\NewsCategoryController;
use App\Http\Controllers\General\NewsController;
use App\Http\Controllers\General\NewsGroupController;
use App\Http\Controllers\General\NewsStreamsController;
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

Route::group(['middleware'=>['auth:web','check_balance','check_token']],function (){
    Route::get('news/groups/{id}',[NewsGroupController::class, 'groups'])->name('news.group');
    Route::get('news/streams/{id}',[NewsStreamsController::class, 'stream'])->name('news.stream');
    Route::get('news/categories/{id}',[NewsCategoryController::class, 'category'])->name('news.category');
    Route::resource('news',NewsController::class);
    Route::resource('home',HomeController::class);
});

Route::group(['middleware'=>['auth:web']], function (){
    Route::get('payments/callback/{id}',[PaymentController::class, 'callback'])->name('callback');
    Route::patch('payments/clear-balance/{id}',[PaymentController::class,'clearBalance'])->name('clearBalance');
    Route::resource('payments',PaymentController::class);
});


require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
require __DIR__.'/enterprise.php';
require __DIR__.'/account.php';


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize');
    echo "Config cleared<br>";
});
