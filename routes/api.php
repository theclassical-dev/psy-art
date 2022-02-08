<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
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

//users
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

//admin
Route::post('/boss/register', [App\Http\Controllers\AdminController::class, 'register']);
Route::post('/boss/login', [App\Http\Controllers\AdminController::class, 'login']);

//admin middleware
Route::group(['middleware' => ['auth:admin'], 'prefix' => 'boss'], function () {

    Route::get('/get', [App\Http\Controllers\AdminController::class, 'get']);
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout']);
    
});

//user middleware
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {

    Route::get('/getus', [App\Http\Controllers\AuthController::class, 'get']);
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/createAccountDatials', [App\Http\Controllers\MainController::class, 'createAccDetail']);
    
});



