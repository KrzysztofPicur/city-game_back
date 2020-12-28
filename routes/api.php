<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TestController;

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
    Route::post('register', [ AuthController::class, 'register']);
    Route::post('login',    [ AuthController::class, 'login']);
    Route::post('refresh',  [ AuthController::class, 'refresh']);
    Route::get('profile',   [ AuthController::class, 'profile']);
    Route::post('logout',   [ AuthController::class, 'logout']);

});

    Route::get('google',          [ GoogleController::class, 'redirectToGoogle']);
    Route::get('google/callback', [ GoogleController::class, 'handleGoogleCallback']);


    Route::resource('posts', PostController::class);
    Route::get('profile/myposts', [PostController::class, 'getAllUserPosts']);


    Route::post('posts/{id}/comments',       [ CommentController::class, 'store']);
   

