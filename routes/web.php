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
    // ----------------------------- Admin Section ----------------------------- //
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // --------- Admin User Management --------- //
    Route::get('/admin/user-management', [AdminController::class, 'userManagement'])->name('admin.userManagement');
    Route::get('/admin/user-management/{id}/edit', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::post('/admin/user-management/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/user-management/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.resetPassword');

    // Admin Rooms
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    Route::post('/admin/rooms', [AdminController::class, 'storeRoom'])->name('admin.rooms.store');
    Route::get('/admin/rooms/{id}/edit', [AdminController::class, 'editRoom'])->name('admin.rooms.edit');
    Route::put('/admin/rooms/{id}', [AdminController::class, 'updateRoom'])->name('admin.rooms.update');
    Route::delete('/admin/rooms/{id}', [AdminController::class, 'deleteRoom'])->name('admin.rooms.delete');
    
    Route::get('/admin/rooms/{room}/instruments', [AdminController::class, 'showRoomInstruments'])->name('admin.rooms.instruments');
    Route::post('/admin/rooms/{room}/add-instrument', [AdminController::class, 'addInstrumentToRoom'])->name('admin.rooms.addInstrument');
    Route::post('/admin/rooms/{room}/instruments/{instrument}/update', [AdminController::class, 'updateRoomInstrument'])->name('admin.rooms.updateInstrument');
    Route::delete('/admin/rooms/{room}/instruments/{instrument}/detach', [AdminController::class, 'detachInstrumentFromRoom'])->name('admin.rooms.detachInstrument');

    // --------- Admin Promotions --------- //
    Route::get('/admin/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
    Route::get('/admin/promotions/create', [AdminController::class, 'createPromotion'])->name('admin.promotions.create');
    Route::get('/admin/promotions/{id}/edit', [AdminController::class, 'editPromotion'])->name('admin.promotions.edit');
    Route::post('/promotions/store', [AdminController::class, 'storePromotion'])->name('admin.promotions.store');
    Route::post('/promotions/{id}/update', [AdminController::class, 'updatePromotion'])->name('admin.promotions.update');
    Route::post('/promotions/{id}/delete', [AdminController::class, 'deletePromotion'])->name('admin.promotions.delete');
    Route::post('/promotions/{id}/toggle', [AdminController::class, 'togglePromotion'])->name('admin.promotions.toggle');

    // Admin Musical Instruments
    Route::get('/admin/instrument-categories', [AdminController::class, 'instrumentCategories'])->name('admin.instrumentCategories');
    Route::post('/admin/instrument-categories', [AdminController::class, 'storeInstrumentCategory'])->name('admin.instrumentCategories.store');
    Route::post('/admin/instrument-categories/delete-selected', [AdminController::class, 'deleteSelectedInstrumentCategories'])->name('admin.instrumentCategories.deleteSelected');
    Route::get('/admin/instruments/{category_id}', [AdminController::class, 'instrumentsByCategory'])->name('admin.instruments.byCategory');
    Route::post('/admin/instruments', [AdminController::class, 'storeInstrument'])->name('admin.instruments.store');
    Route::post('/admin/instruments/{id}/update', [AdminController::class, 'updateInstrument'])->name('admin.instruments.update');
    Route::delete('/admin/instruments/{id}', [AdminController::class, 'deleteInstrument'])->name('admin.instruments.delete');
    Route::get('/admin/instruments/{id}/show', [AdminController::class, 'showInstrument'])->name('admin.instruments.show');
    Route::get('/admin/instruments/{id}/add-room', [AdminController::class, 'addRoomToInstrument'])->name('admin.instruments.addRoom');
    Route::post('/admin/instruments/{id}/store-room', [AdminController::class, 'storeInstrumentRoom'])->name('admin.instruments.storeRoom');
    Route::post('/admin/instruments/{instrument}/rooms/{room}/update', [AdminController::class, 'updateInstrumentRoom'])->name('admin.instruments.updateRoom');
    Route::delete('/admin/instruments/{instrument}/rooms/{room}/detach', [AdminController::class, 'detachRoom'])->name('admin.instruments.detachRoom');

    // Admin Log
    Route::get('/admin/log', [AdminController::class, 'log'])->name('admin.log');

    // Admin profile
    Route::get('/admin/profile', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // ----------------------------- User Section ----------------------------- //
    // User Home
    Route::get('/user/home', [UserController::class, 'home'])->name('user.home');

    // Profile (แก้ไขข้อมูลผู้ใช้)
    Route::get('/user/profile', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
});
