<?php

use App\Http\Controllers\Account\AccountSubscriptionController;
use App\Http\Controllers\Enterprise\AccountSetupController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:web','role:Enterprise|super-admin']],function (){
    Route::resource('account-setup',AccountSetupController::class);
    Route::resource('account/subscription',AccountSubscriptionController::class);

});
