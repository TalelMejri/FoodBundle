<?php

use App\Http\Controllers\auth\LoginUser;
use App\Http\Controllers\Auth\RegisterUser;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\User\UserController;
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

Route::group(['prefix'=>'/auth'],function(){
    Route::post('/registerUser',[RegisterUser::class,'RegisterUser']);
    Route::post('/loginUser',[LoginUser::class,'LoginUser']);
});

Route::group(['prefix'=>'/user'],function(){
    Route::get('/countUser',[UserController::class,'coutUser']);
    Route::get('/getuser',[UserController::class,'index']);
    Route::delete('/deleteUser/{id}',[UserController::class,'destroy']);
});

Route::group(['prefix'=>'/product'],function(){
    Route::post('/addCategory',[ProductController::class,'addCategory']);
    Route::get('/AllTypeCategorie',[ProductController::class,'AllTypeCategorie']);
    Route::get('/GetOptionForCategorie',[ProductController::class,'GetOptionForCategorie']);
});
