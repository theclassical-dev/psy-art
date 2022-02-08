<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
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
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
//admin register
Route::post('/boss/register', [App\Http\Controllers\AdminController::class, 'register']);
Route::post('/boss/login', [App\Http\Controllers\AdminController::class, 'login']);

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'boss'], function () {

    Route::get('/get', [App\Http\Controllers\AdminController::class, 'get']);
    
});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {

    Route::get('/get', [App\Http\Controllers\AuthController::class, 'get']);
    
});



