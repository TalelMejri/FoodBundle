<?php

use App\Http\Controllers\auth\LoginUser;
use App\Http\Controllers\Auth\RegisterUser;
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
