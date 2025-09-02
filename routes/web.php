<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth'])->group(function() {
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // --------- Admin User Management --------- //
    Route::get('/admin/user-management', [AdminController::class, 'userManagement'])->name('admin.userManagement');
    Route::get('/admin/user-management/{id}/edit', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::post('/admin/user-management/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/user-management/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.resetPassword');

    // Admin Rooms
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    // Admin Promotions
    Route::get('/admin/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
    // Admin Musical Instruments
    Route::get('/admin/instruments', [AdminController::class, 'instruments'])->name('admin.instruments');
    // Admin Log
    Route::get('/admin/log', [AdminController::class, 'log'])->name('admin.log');

    // Admin profile
    Route::get('/admin/profile', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // User Home
    Route::get('/user/home', [UserController::class, 'home'])->name('user.home');

    // Profile (แก้ไขข้อมูลผู้ใช้)
    Route::get('/user/profile', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    
});
