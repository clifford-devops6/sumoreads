<?php

use App\Http\Controllers\Account\AccountProfileController;
use App\Http\Controllers\Account\AccountSubscriptionController;
use App\Http\Controllers\Account\UpgradeController;
use App\Http\Controllers\General\PersonalizeController;
use App\Http\Controllers\General\ReadlistController;
use App\Http\Controllers\General\ShareController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:web','check_balance','check_token']],function (){
    Route::post('account/initiate-upgrade/{id}',[UpgradeController::class,'initiateUpgrade'])->name('initiate.upgrade');
    Route::get('account/share/article/{id}',[ShareController::class,'articleShare'])->name('article.share');
    Route::get('account/share/group-share/{id}',[ShareController::class,'groupShare'])->name('group.share');
    Route::resource('account/share',ShareController::class);
    Route::get('readlist/read',[ReadlistController::class,'read'])->name('read.readlist');
    Route::get('readlist/unread',[ReadlistController::class,'unread'])->name('unread.readlist');
    Route::patch('readlist/confirm/{id}',[ReadlistController::class,'confirmRead'])->name('confirm.read');
    Route::resource('readlist',ReadlistController::class);
    Route::post('personalize/remove-categories',[PersonalizeController::class,'removeCategoryPersonal'])->name('personalize.remove.categories');
    Route::post('personalize/add-categories',[PersonalizeController::class,'addCategoryPersonal'])->name('personalize.add.categories');
    Route::post('personalize/remove-sources',[PersonalizeController::class,'removeSource'])->name('personalize.remove.sources');
    Route::post('personalize/add-sources',[PersonalizeController::class,'addSource'])->name('personalize.add.sources');
    Route::resource('account/personalize',PersonalizeController::class);
    Route::post('account/subscription/add-slot',[AccountSubscriptionController::class,'addSlot'])->name('add.slot');
    Route::post('account/subscription/pay-now',[AccountSubscriptionController::class,'payNow'])->name('pay.now');
    Route::resource('account/subscription',AccountSubscriptionController::class);
    Route::get('account/upgrade',[AccountProfileController::class,'upgrade'])->name('account.upgrade');
    Route::patch('account/profile/security-update/{id}',[AccountProfileController::class,'profilePassword'])->name('profile.password');
    Route::get('account/profile/security',[AccountProfileController::class,'profileSecurity'])->name('profile.security');
    Route::patch('account/profile/update-email/{id}',[AccountProfileController::class,'updateEmail'])->name('update.email');
    Route::resource('account/profile',AccountProfileController::class);
});
