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

Route::prefix('auth')->middleware('api')->controller(PostController::class)->group(function(){
    Route::post('post','store');
    Route::get('post/{post}','show');
    Route::get('posts/all','index');
});

Route::prefix('auth')->middleware('api')->controller(CommentController::class)->group(function(){
    Route::post('comment','store');
    Route::get('comment/{comment}','show');
    Route::get('comments/all','index');
});

Route::prefix('auth')->middleware('api')->controller(Answer_CommentController::class)->group(function(){
    Route::post('answer','store');
    Route::get('answer_comment/{answer_comment}','show');
    Route::get('comments/unanswered','index');

});

Route::post('comments/{comment}/like', [CommentController::class, 'like']);
Route::post('comments/{comment}/unlike', [CommentController::class, 'unlike']);
