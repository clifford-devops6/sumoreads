<?php

use App\Http\Controllers\Account\AccountProfileController;
use App\Http\Controllers\Account\AccountSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::group([],function (){
    Route::post('account/subscription/add-slot',[AccountSubscriptionController::class,'addSlot'])->name('add.slot');
    Route::post('account/subscription/pay-now',[AccountSubscriptionController::class,'payNow'])->name('pay.now');
    Route::resource('account/subscription',AccountSubscriptionController::class);
    Route::patch('account/profile/security-update/{id}',[AccountProfileController::class,'profilePassword'])->name('profile.password');
    Route::get('account/profile/security',[AccountProfileController::class,'profileSecurity'])->name('profile.security');
    Route::patch('account/profile/update-email/{id}',[AccountProfileController::class,'updateEmail'])->name('update.email');
    Route::resource('account/profile',AccountProfileController::class);
});
