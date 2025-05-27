<?php

use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

//post
Route::middleware('auth:api')->get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);

//profile
Route::prefix('profile')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [UserController::class, 'me']);
        Route::post('/image', [UserController::class, 'uploadProfileImage']);
    });
});

//ranking
Route::get('users/rankings', [UserController::class, 'rankings']);


