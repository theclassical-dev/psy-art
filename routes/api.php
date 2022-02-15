<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BossController;
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
// all uploaded Arts for public dashboard
Route::get('/allArt', [App\Http\Controllers\PublicController::class, 'artGallery']);
Route::get('/gen',[App\Http\Controllers\PublicController::class, 'gen']);

//searchArt
Route::get('/searchArt/{search}',[App\Http\Controllers\PublicController::class, 'searchArt']);

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
    //get all the art uploaded
    Route::get('/all-artwork', [App\Http\Controllers\BossController::class, 'artArtwork']);
    //count registered CreateUsers
    Route::get('/count-registeredUsers', [App\Http\Controllers\BossController::class, 'countUser']);
    //update from sale to sold
    Route::put('/update-to-sold/{id}', [App\Http\Controllers\BossController::class, 'artSold']);
    //get count of sold and sales
    Route::get('/get-sold-sale', [App\Http\Controllers\BossController::class, 'getSoldSale']);

});

//user middleware
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {

    Route::get('/getus', [App\Http\Controllers\AuthController::class, 'get']);
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/createAccountDetails', [App\Http\Controllers\MainController::class, 'createAccDetail']);
    Route::post('/updateAccDetail/{id}', [App\Http\Controllers\MainController::class, 'updateAccDetail']);
    Route::post('/uploadArt', [App\Http\Controllers\MainController::class, 'uploadArt']);
    Route::put('/updateArt/{id}', [App\Http\Controllers\MainController::class, 'updateArt']);
    Route::get('/getArt', [App\Http\Controllers\MainController::class, 'getArt']);
    Route::get('/getUserAccount', [App\Http\Controllers\MainController::class, 'getAccount']);
    Route::delete('/deleteArtWork/{id}', [App\Http\Controllers\MainController::class, 'deleteArt']);
    //profile Image 
    Route::post('/upload-profile-image', [App\Http\Controllers\AuthController::class, 'uploadProfileImage']);
    Route::put('/update-profile-image/{id}', [App\Http\Controllers\AuthController::class, 'updateProfileImage']);
});




