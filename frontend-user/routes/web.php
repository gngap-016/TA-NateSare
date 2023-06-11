<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/materi/gratis', [HomeController::class, 'freeMateries']);
Route::get('/materi/berbayar', [HomeController::class, 'paidMateries']);
Route::get('/materi/{parameter}', [HomeController::class, 'detailMateries']);
Route::post('/materi/{parameter}', [HomeController::class, 'commentMateries']);
Route::get('/masuk', [AuthController::class, 'login']);