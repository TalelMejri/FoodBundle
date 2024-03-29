<?php

use App\Http\Controllers\auth\LoginUser;
use App\Http\Controllers\Auth\RegisterUser;
use App\Http\Controllers\Auth\ResetPassword\ChangerPassword;
use App\Http\Controllers\Auth\ResetPassword\ForgotPassword;
use App\Http\Controllers\auth\Verifyemail\VerificationEmail;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\commande\CommandeController;
use App\Http\Controllers\notification\ControllerNotification;
use App\Http\Controllers\Option\OptionController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\test;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
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
//Broadcast::routes(['middleware' => ['auth:sanctum']]);
//Broadcast::routes(['predix' => 'api', 'middleware' => ['auth:api']]);
// Route::post('/broadcasting/auth', function () {
//     return Auth::user();
//  });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'/auth'],function(){
    Route::post('/registerUser',[RegisterUser::class,'RegisterUser']);
    Route::post('/loginUser',[LoginUser::class,'LoginUser']);
    Route::get('/exist/{email}',[LoginUser::class,'exist_email']);
});

Route::group(['prefix'=>'/commande'],function(){
    Route::post('/AddCommande',[CommandeController::class,'AddCommande']);
    Route::get('/AllCommande',[CommandeController::class,'AllCommande']);
    Route::get('/CommandeForUser',[CommandeController::class,'CommandeForUser']);
    Route::get('/AllCommandeAccpted',[CommandeController::class,'AllCommandeAccpted']);
    Route::get('/AllCommandeRejeter',[CommandeController::class,'AllCommandeRejeter']);
    Route::delete('/deleteCommande/{id}',[CommandeController::class,'deleteCommande']);
    Route::delete('/rejeterCommande',[CommandeController::class,'rejeterCommande']);
    Route::put('/AccepterCommande',[CommandeController::class,'AccepterCommande']);
    Route::get('/countCommande',[CommandeController::class,'countCommande']);
});

Route::group(['prefix'=>'/user'],function(){
    Route::get('/countUser',[UserController::class,'coutUser']);
    Route::delete('/deleteUser/{id}',[UserController::class,'destroy']);
    Route::get('/getuser',[UserController::class,'index']);
});

Route::group(['prefix'=>"/category"],function(){
    Route::post('/addCategory',[CategoryController::class,'addCategory']);
    Route::get('/AllTypeCategorie',[CategoryController::class,'AllTypeCategorie']);
    Route::get('/getAllCategorie',[CategoryController::class,'getAllCategorie']);
    Route::delete('/deleteCategory/{id}',[CategoryController::class,'deleteCategory']);
    Route::POST('/UpdateCategory/{id}',[CategoryController::class,'UpdateCategory']);
    Route::get('/findCategoryByIid/{id}',[CategoryController::class,'findCategoryByIid']);
    Route::get('/CountCategory',[CategoryController::class,'CountCategory']);
    Route::get('/exist_name/{name}',[CategoryController::class,'exist_name']);
    Route::get('/GetOptionForCategorie',[CategoryController::class,'GetOptionForCategorie']);
});

Route::group(['prefix'=>"/option"],function(){
    Route::delete('/deleteOption/{id}',[OptionController::class,'deleteOption']);
    Route::POST('/UpdateOption/{id}',[OptionController::class,'UpdateOption']);
    Route::get('/findOptionByIid/{id}',[OptionController::class,'findOptionByIid']);
    Route::POST('/addOption',[OptionController::class,'addOption']);
    Route::get('/countOption',[OptionController::class,'CountOption']);
    Route::post('/addOptionSpecifique',[OptionController::class,'addOptionSpecifique']);
    Route::get('/CountOptionSpecifique',[OptionController::class,'CountOptionSpecifique']);
    Route::get('/getOptionByIdCategory/{id}',[OptionController::class,'getOptionByIdCategory']);
    Route::delete('/deleteOptionSpecifique/{id}',[OptionController::class,'deleteOptionSpecifique']);
    Route::POST('/UpdateOptionSpecifique/{id}',[OptionController::class,'UpdateOptionSpecifique']);
    Route::get('/getOptionGlobal',[OptionController::class,'getOptionGlobal']);
    Route::get('/getOptionSpecifique',[OptionController::class,'getOptionSpecifique']);
    Route::get('/getAlloption',[OptionController::class,'getAlloption']);
});

Route::group(['prefix'=>'/product'],function(){
    Route::delete('/deleteProduct/{id}',[ProductController::class,'deleteProduct']);
    Route::POST('/UpdateProduct/{id}',[ProductController::class,'UpdateProduct']);
    Route::get('/findProductByIid/{id}',[ProductController::class,'findProductByIid']);
    Route::post('/Add_Product',[ProductController::class,'Add_Product']);
    Route::get('/countproduct',[ProductController::class,'countProduct']);
    Route::get('/AllProduct',[ProductController::class,'AllProduct']);
    Route::get('/GetProudctOptionSpecifiqueCategory',[ProductController::class,'GetProudctOptionSpecifiqueCategory']);
    Route::get('/getProductByIdCategory/{id}',[ProductController::class,'getProductByIdCategory']);
    Route::get('/GetProductCategoryOption',[ProductController::class,'GetProductCategoryOption']);
    Route::get('/getALLproduct',[ProductController::class,'getALLproduct']);
    Route::post('/addrate',[ProductController::class,'addrate']);
    Route::get('/getrate',[ProductController::class,'getrate']);
    Route::get('/Avgrate/{id}',[ProductController::class,'Avgrate']);
});

Route::group(['prefix'=>'/resetPassword'],function(){
    Route::post('/forgot_password',[ForgotPassword::class,'forgot_password']);
    Route::post('/changer_password',[ChangerPassword::class,'changer_password']);
    Route::get('/exist_code/{code}',[ChangerPassword::class,'exist_code']);
});

Route::group(['prefix'=>"/email"],function(){
    Route::get('/verify/{email}', [VerificationEmail::class, 'verify_email']);
    Route::get('/renvoyer/{email}', [VerificationEmail::class, 'renvoyer']);
    Route::put('/updated', [VerificationEmail::class, 'updated']);
    Route::get('/sendmailChanger/{email}', [VerificationEmail::class, 'sendmailChanger']);
});

Route::middleware("auth:sanctum")->group(function(){

    Route::group(['prefix'=>'/user'],function(){
        Route::Post('/Updateuser',[UserController::class,'update']);
        Route::put('/changerPassword/{password}',[UserController::class,'changerPassword']);
        Route::get('/samePassword/{password}',[UserController::class,'samePassword']);
        Route::get('/countLiked/{id}',[UserController::class,'countLiked']);
        Route::Post('/AddLiked/{id}',[UserController::class,'AddLiked']);
        Route::get('/checkLiked/{id}',[UserController::class,'checkLiked']);
        Route::delete('/deleteFavorite/{id}',[UserController::class,'deleteFavorite']);
        Route::get('/GetAllLikedProduct/{id}',[UserController::class,'GetAllLikedProduct']);
        Route::get('/getAllProductLiekd/{id}',[UserController::class,'getAllProductLiekd']);
    });

    Route::group(['prefix'=>'/notif'],function(){
        Route::get('/getnotif',[ControllerNotification::class,'getNotification']);
        Route::get('/getAllNotification',[ControllerNotification::class,'getAllNotification']);
        Route::put('/changeretat/{id}',[ControllerNotification::class,'changeretat']);
        Route::delete('/deleteAllNotif',[ControllerNotification::class,'deleteAllNotif']);
        Route::delete('/deleteNotification/{id}',[ControllerNotification::class,'deleteNotification']);
    });

    Route::group(['prefix'=>'/product'],function(){
        Route::post('/addrate',[ProductController::class,'addrate']);
        Route::get('/getrate',[ProductController::class,'getrate']);
        Route::get('/Avgrate/{id}',[ProductController::class,'Avgrate']);
    });

});



