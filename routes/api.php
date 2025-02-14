<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
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

Route::middleware(['auth'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('posts/{post}', [PostController::class, 'show']);
Route::get('posts/{post}/comments', [CommentController::class, 'show']);
Route::post('posts/{post}/comments', [CommentController::class, 'store']);
