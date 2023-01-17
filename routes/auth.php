<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthenticatedUser;
use App\Http\Controllers\Auth\CorporateRegistration;
use App\Http\Controllers\Auth\EnterpriseRegistration;
use App\Http\Controllers\Auth\StandardRegistration;
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


Route::group(['middleware'=>['guest']], function(){
    Route::get('auth/login',[AuthController::class, 'login'])->name('login');
    Route::get('auth/pricing',[AuthController::class, 'pricing'])->name('pricing');
    Route::get('auth/register',[AuthController::class, 'register'])->name('register');
    Route::post('auth/free-account',[AuthController::class, 'freeAccount'])->name('free-account');
    Route::post('auth/authenticate',[AuthController::class, 'authenticate'])->name('authenticate');

    Route::get('auth/forgot-password',[AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('auth/password-mail',[AuthController::class, 'requestStore'])->name('request.store');
    Route::get('auth/password-update',[AuthController::class, 'passwordUpdate'])->name('password.form');
    Route::post('auth/new-password',[AuthController::class, 'newPassword'])->name('new.password');

    Route::get('auth/standard',[StandardRegistration::class, 'standard'])->name('standard.register');
    Route::post('auth/standard-create',[StandardRegistration::class, 'create'])->name('standard.create');

    Route::get('auth/enterprise',[EnterpriseRegistration::class, 'enterprise'])->name('enterprise.register');
    Route::post('auth/enterprise-create',[EnterpriseRegistration::class, 'create'])->name('enterprise.create');

    Route::get('auth/corporate',[CorporateRegistration::class, 'corporate'])->name('corporate.register');
    Route::post('auth/corporate-create',[CorporateRegistration::class, 'create'])->name('corporate.create');


});

Route::group(['middleware'=>['auth:web']], function (){
    Route::post('logout',[AuthenticatedUser::class, 'destroy'])->name('logout');
});
