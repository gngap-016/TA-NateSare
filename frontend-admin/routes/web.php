<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Dashboard\Admin\CategoryController;
use App\Http\Controllers\Dashboard\Admin\DashboardController;
use App\Http\Controllers\Dashboard\Admin\PostController;
use App\Http\Controllers\Dashboard\Admin\StudentController;
use App\Http\Controllers\Dashboard\Admin\TeacherController;
use App\Http\Controllers\Dashboard\Admin\AdministratorController;
use App\Http\Controllers\Dashboard\Admin\MyProfileController;
use Illuminate\Support\Facades\Http;
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

Route::get('/admin/posts', [PostController::class, 'index'])->middleware('is_admin');

Route::get('/', [AuthenticationController::class, 'login']);
Route::post('/login', [AuthenticationController::class, 'processLogin']);
Route::get('/logout', [AuthenticationController::class, 'logout'])->middleware('is_login');

Route::middleware('is_login')->group(function () {
    Route::get('/admin', [DashboardController::class, 'index']);

    Route::get('/admin/materies', [PostController::class, 'index']);

    Route::get('/admin/materies/create', [PostController::class, 'create']);
    Route::get('/admin/materies/check-slug', [PostController::class, 'checkSlug']);
    Route::get('/admin/materies/{post_slug}', [PostController::class, 'show']);
    Route::get('/admin/materies/edit/{parameter}', [PostController::class, 'edit']);
    Route::get('/admin/my-materies', [PostController::class, 'myMateries']);
    Route::post('/admin/materies', [PostController::class, 'store']);
    Route::put('/admin/materies/{parameter}', [PostController::class, 'update']);
    Route::delete('/admin/materies/{parameter}', [PostController::class, 'destroy']);
    
    Route::get('/admin/categories', [CategoryController::class, 'index']);
    Route::get('/admin/categories/create', [CategoryController::class, 'create']);
    Route::get('/admin/categories/edit/{parameter}', [CategoryController::class, 'edit']);
    Route::get('/admin/categories/check-slug', [CategoryController::class, 'checkSlug']);
    Route::post('/admin/categories', [CategoryController::class, 'store']);
    Route::put('/admin/categories/{parameter}', [CategoryController::class, 'update']);
    Route::delete('/admin/categories/{parameter}', [CategoryController::class, 'destroy']);

    Route::get('/admin/users/students', [StudentController::class, 'index']);
    Route::get('/admin/users/students/create', [StudentController::class, 'create']);
    Route::get('/admin/users/students/edit/{parameter}', [StudentController::class, 'edit']);
    Route::post('/admin/users/students', [StudentController::class, 'store']);
    Route::put('/admin/users/students/reset-password/{parameter}', [StudentController::class, 'resetPassword']);
    Route::put('/admin/users/students/{parameter}', [StudentController::class, 'update']);
    Route::delete('/admin/users/students/{parameter}', [StudentController::class, 'destroy']);

    Route::get('/admin/users/teachers', [TeacherController::class, 'index']);
    Route::get('/admin/users/teachers/create', [TeacherController::class, 'create']);
    Route::get('/admin/users/teachers/edit/{parameter}', [TeacherController::class, 'edit']);
    Route::post('/admin/users/teachers', [TeacherController::class, 'store']);
    Route::put('/admin/users/teachers/reset-password/{parameter}', [TeacherController::class, 'resetPassword']);
    Route::put('/admin/users/teachers/{parameter}', [TeacherController::class, 'update']);
    Route::delete('/admin/users/teachers/{parameter}', [TeacherController::class, 'destroy']);

    Route::get('/admin/users/administrators', [AdministratorController::class, 'index']);
    Route::get('/admin/users/administrators/create', [AdministratorController::class, 'create']);
    Route::get('/admin/users/administrators/edit/{parameter}', [AdministratorController::class, 'edit']);
    Route::post('/admin/users/administrators', [AdministratorController::class, 'store']);
    Route::put('/admin/users/administrators/reset-password/{parameter}', [AdministratorController::class, 'resetPassword']);
    Route::put('/admin/users/administrators/{parameter}', [AdministratorController::class, 'update']);
    Route::delete('/admin/users/administrators/{parameter}', [AdministratorController::class, 'destroy']);

    Route::get('/admin/my-profile', [MyProfileController::class, 'index']);
    Route::get('/admin/my-profile/edit', [MyProfileController::class, 'edit']);
    Route::get('/admin/my-profile/change-password', [MyProfileController::class, 'changePassword']);
    Route::put('/admin/my-profile/{parameter}', [MyProfileController::class, 'update']);
    Route::put('/admin/my-profile/change-password/{parameter}', [MyProfileController::class, 'updatePassword']);
});

Route::get('/check', function() {
    if(isset($_COOKIE['my_token']) && isset($_COOKIE['my_key'])) {
        $user = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->get(env('SERVER_API') . 'users/' . $_COOKIE['my_key']);
    
        return json_decode($user);
    }

    abort(403);
});