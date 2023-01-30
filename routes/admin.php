<?php


use App\Http\Controllers\Admin\AdminAccountTypes;
use App\Http\Controllers\Admin\AdminBugController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminLangaugeController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminSourceController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::Group(['middleware'=>['auth:admin']],function (){
    Route::resource('admin/advertisement',AdvertisementController::class);
    Route::resource('admin/account-types',AdminAccountTypes::class);
    Route::resource('admin/bugs',AdminBugController::class);
    Route::resource('admin/messages',AdminMessageController::class);
    Route::resource('admin/articles',AdminNewsController::class);
    Route::patch('admin/sources/fetch/{id}',[AdminSourceController::class,'attemptFetch'])->name('fetch');
    Route::resource('admin/sources',AdminSourceController::class);
    Route::resource('admin/categories',AdminCategoryController::class);
    Route::resource('admin/languages',AdminLangaugeController::class);
    Route::resource('admin',AdminController::class);
});
