<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\OrderController;
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
Route::prefix('/house')->group(function (){
    Route::get('/',[HouseController::class,'index']);
    Route::get('/{id}',[HouseController::class,'detail']);
    Route::post('/create',[HouseController::class,'create']);
    Route::get('/search',[HouseController::class,'search']);
    Route::get('/search/{start_date}/{end_date}/{bedroom}/{bathroom}/{price_min}/{price_max}/{address}',[HouseController::class,'search']);

});


Route::prefix('/order')->group(function (){
    Route::post('/house-rent/{id}',[OrderController::class,'houseRent']);
    Route::post('/rent-confirm/{id}',[OrderController::class,'rentConfirm']);
    Route::get('/rent-history',[OrderController::class,'rentHistory']);
    Route::post('/cancel-rent/{id}',[OrderController::class,'cancelRent']);
    Route::get('/rent-history-house/{id}',[OrderController::class,'rentHistoryHouse']);

});

Route::middleware("api")->group(function (){
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/logout", [AuthController::class, "logout"]);
});


