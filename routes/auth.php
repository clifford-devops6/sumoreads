<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use  \App\Http\Controllers\Admin\Auth\AdminAuthController;
use  \App\Http\Controllers\Admin\Auth\AuthenticatedAdmin;


// Auth routes. Customized to fit the application needs
Route::group(['middleware'=>['guest:admin']], function(){
    Route::get('/admin/auth/login',[AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('admin/auth/authenticate',[AdminAuthController::class, 'authenticate'])->name('admin.authenticate');
    Route::get('/admin/auth/register',[AdminAuthController::class, 'register'])->name('admin.register');
    Route::post('/admin/auth/create',[AdminAuthController::class, 'create'])->name('admin.save');

});


Route::group(['middleware'=>['auth:admin']], function (){
    Route::post('/admin/auth/logout',[AuthenticatedAdmin::class, 'destroy'])->name('admin.logout');
});


Route::group(['middleware'=>['guest:web']], function(){
    Route::get('auth/login',[AuthController::class, 'login'])->name('login');


});
