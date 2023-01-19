<?php


use App\Http\Controllers\Enterprise\AccountSetupController;
use App\Http\Controllers\Enterprise\GroupController;
use App\Http\Controllers\Enterprise\ManageAccountcontroller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:web','role:Enterprise|super-admin']],function (){
    Route::patch('group/update/{id}',[GroupController::class,'update'])->name('group.update');
    Route::post('group/create',[GroupController::class,'create'])->name('group.create');
    Route::delete('account/manage/delete-invite/{id}',[ManageAccountcontroller::class,'deleteInvite'])->name('invite.delete');
    Route::patch('account/manage/remove-user/{id}',[ManageAccountcontroller::class,'removeUser'])->name('remove.user');
    Route::post('account/manage/send-invitation',[ManageAccountcontroller::class,'sendInvitation'])->name('send.invitation');
    Route::resource('account/manage',ManageAccountcontroller::class);
    Route::resource('account-setup',AccountSetupController::class);


});
