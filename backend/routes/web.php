<?php

use App\Events\notif;
use App\Events\PrivateTest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/broadcast",function(){
     notif::dispatch();
     return "sent";
});

Route::get("/broadcast-private",function(){
    $user=App\Models\User::find(1);
    PrivateTest::dispatch($user);
    return 'sent'.$user->name;
});
