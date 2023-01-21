<?php


use App\Http\Controllers\Enterprise\AccountSetupController;
use App\Http\Controllers\Enterprise\GroupController;
use App\Http\Controllers\Enterprise\ManageAccountcontroller;
use App\Http\Controllers\General\PersonalizeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:web','role:Enterprise|super-admin']],function (){
    Route::post('enterprise/remove-categories',[PersonalizeController::class,'removeCategory'])->name('enterprise.remove.category');
    Route::post('enterprise/add-categories',[PersonalizeController::class,'addCategory'])->name('enterprise.add.category');

    Route::post('enterprise/remove-sources',[PersonalizeController::class,'removeEnterprise'])->name('enterprise.remove.sources');
    Route::post('enterprise/add-sources',[PersonalizeController::class,'addEnterprise'])->name('enterprise.add.sources');
    Route::post('group/add-categories',[GroupController::class,'addCategory'])->name('group.add.categories');
    Route::post('group/remove-categories',[GroupController::class,'removeCategory'])->name('group.remove.categories');
    Route::post('group/remove-sources',[GroupController::class,'removeSource'])->name('group.remove.sources');
    Route::post('group/add-sources',[GroupController::class,'addSource'])->name('group.add.sources');
    Route::post('group/remove-users',[GroupController::class,'removeUsers'])->name('group.remove.users');
    Route::post('group/add-users',[GroupController::class,'addUsers'])->name('group.add.users');
    Route::patch('group/update/{id}',[GroupController::class,'update'])->name('group.update');
    Route::delete('group/delete/{id}',[GroupController::class,'delete'])->name('group.delete');
    Route::post('group/create',[GroupController::class,'create'])->name('group.create');
    Route::delete('account/manage/delete-invite/{id}',[ManageAccountcontroller::class,'deleteInvite'])->name('invite.delete');
    Route::patch('account/manage/remove-user/{id}',[ManageAccountcontroller::class,'removeUser'])->name('remove.user');
    Route::post('account/manage/send-invitation',[ManageAccountcontroller::class,'sendInvitation'])->name('send.invitation');
    Route::resource('account/manage',ManageAccountcontroller::class);
    Route::resource('account-setup',AccountSetupController::class);


});
