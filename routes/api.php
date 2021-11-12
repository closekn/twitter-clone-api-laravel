<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
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

Route::get('/users/{user}', [UserController::class, 'show']);

Route::get('/tweets', [TweetController::class, 'index']);
Route::post('/tweets', [TweetController::class, 'store'])->middleware('auth:sanctum');
Route::get('/tweets/{tweet}', [TweetController::class, 'show']);
Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/like', [LikeController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/like', [LikeController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
