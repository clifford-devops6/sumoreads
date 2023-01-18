<?php


use App\Http\Controllers\Enterprise\AccountSetupController;
use App\Http\Controllers\Enterprise\ManageAccountcontroller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:web','role:Enterprise|super-admin']],function (){
    Route::resource('account/manage',ManageAccountcontroller::class);
    Route::resource('account-setup',AccountSetupController::class);


});
