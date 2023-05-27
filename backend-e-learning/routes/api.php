<?php

use App\Http\Controllers\Auth\AuthAdmin;
use App\Http\Controllers\CategoryController;
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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/posts', [PostController::class, 'allPosts']);
Route::get('/posts/free', [PostController::class, 'freePosts']);
Route::get('/posts/paid', [PostController::class, 'paidPosts']);
Route::get('/posts/published', [PostController::class, 'publishedPosts']);
Route::get('/posts/drafted', [PostController::class, 'draftedPosts']);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts/check-slug', [PostController::class, 'checkSlug']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post:slug}', [PostController::class, 'update']);
    Route::delete('/posts/{post:slug}', [PostController::class, 'destroy']);

    Route::post('/comment', [CommentController::class, 'store']);

    Route::get('/categories/{category:slug}', [CategoryController::class, 'show']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category:slug}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category:slug}', [CategoryController::class, 'destroy']);
});

Route::post('login', [AuthAdmin::class, 'login']);