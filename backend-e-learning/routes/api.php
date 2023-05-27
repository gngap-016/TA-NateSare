<?php

use App\Http\Controllers\Auth\AuthAdmin;
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

Route::post('/posts', [PostController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/posts/{post:slug}', [PostController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/posts/{post:slug}', [PostController::class, 'destroy'])->middleware(['auth:sanctum']);

Route::post('login', [AuthAdmin::class, 'login']);