<?php

use App\Http\Controllers\HouseController;
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
Route::prefix('/houses')->group(function (){
    Route::get('/',[HouseController::class,'index']);
    Route::get('/{id}',[HouseController::class,'detail']);
    Route::post('/',[HouseController::class,'create']);
    Route::post('/search',[HouseController::class,'search']);
});
Route::prefix("/users")->group(function () {
    Route::get("/house", [\App\Http\Controllers\UserController::class, "getAllHouse"]);
});

Route::middleware("api")->group(function (){
    Route::post("/login", [\App\Http\Controllers\AuthController::class, "login"]);
    Route::post("/register", [\App\Http\Controllers\AuthController::class, "register"]);
    Route::post("/logout", [\App\Http\Controllers\AuthController::class, "logout"]);
    Route::get("/userProfile", [\App\Http\Controllers\AuthController::class, "userProfile"]);
});

Route::prefix("/categories")->group(function () {
    Route::get("/", [\App\Http\Controllers\CategoryController::class, "index"]);
});


