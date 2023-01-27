<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\General\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function (){
    Route::get('group/user/{id}',[ApiController::class, 'getUsers']);
    Route::get('group/group-user/{id}',[ApiController::class, 'getGroupUsers']);
    Route::get('get/sources',[ApiController::class, 'getSources']);
    Route::get('get/categories',[ApiController::class, 'getCategories']);
    Route::get('get/groups/{id}',[ApiController::class, 'getGroups']);
    Route::get('get/posts',[NewsController::class, 'index']);
    Route::get('get/enterprise-streams/{id}',[ApiController::class, 'enterpriseStreams']);
    Route::get('get/enterprise-categories/{id}',[ApiController::class, 'enterpriseCategories']);
    Route::get('get/personal-streams/{id}',[ApiController::class, 'personalStreams']);
    Route::get('get/personal-categories/{id}',[ApiController::class, 'personalCategories']);

});
