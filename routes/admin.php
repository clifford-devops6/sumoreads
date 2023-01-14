<?php


use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminLangaugeController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminSourceController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::Group(['middleware'=>['auth:admin']],function (){
    Route::resource('admin/articles',AdminNewsController::class);
    Route::resource('admin/sources',AdminSourceController::class);
    Route::resource('admin/categories',AdminCategoryController::class);
    Route::resource('admin/languages',AdminLangaugeController::class);
    Route::resource('admin',AdminController::class);
});
