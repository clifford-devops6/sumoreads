<?php

use App\Http\Controllers\General\ContactController;
use App\Http\Controllers\General\NewsController;
use App\Http\Controllers\General\ReportBugController;
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

Route::get('/', function () {
    return inertia('welcome');
});

//Do not require authentication
Route::group([], function (){
    Route::resource('news',NewsController::class);
    Route::resource('contact-us',ContactController::class);
    Route::resource('report-bug',ReportBugController::class);
});


require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
