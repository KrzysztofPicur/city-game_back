<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendController;



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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('register',     [AuthController::class, 'register']);
    Route::post('login',        [AuthController::class, 'login']);
    Route::post('refresh',      [AuthController::class, 'refresh']);
    Route::get('profile',       [AuthController::class, 'profile']);
    Route::post('logout',       [AuthController::class, 'logout']);
});

Route::get('stats',             [StatsController::class,'getAll']);
Route::get('stat/{id}',         [StatsController::class,'getStat']);
Route::get('stats/{what}/{how}',[StatsController::class,'getOrderby']);

Route::get('posts/{idUser}',    [PostController::class,'getPost']);
Route::post('addpost',          [PostController::class,'addPost']);
Route::post('checkPost',            [PostController::class,'check']);

Route::get('user/friend/{id}',  [FriendController::class,'getUserFriend']);
Route::post('addfriend',        [FriendController::class,'addFriend']);

Route::get('google',            [GoogleController::class, 'redirectToGoogle']);
Route::get('google/callback',   [GoogleController::class, 'handleGoogleCallback']);


