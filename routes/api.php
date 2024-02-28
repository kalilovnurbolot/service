<?php

use App\Http\Controllers\Answer_CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProverkaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function(){
        Route::post('login','login');
        Route::get('user','user');
        Route::post('logout','logout');
        Route::post('refresh','refresh');
});
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::post('auth/post', [PostController::class, 'store']);
   
});
Route::prefix('auth')->middleware('api')->controller(CommentController::class)->group(function(){
    Route::post('comment','store');
   
});

Route::prefix('auth')->middleware('api')->controller(Answer_CommentController::class)->group(function(){
    Route::post('answer','store');
   
});