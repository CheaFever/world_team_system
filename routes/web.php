<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

// បញ្ជូនពីទំព័រដើមទៅកាន់ទំព័រ Login របស់ Admin ផ្ទាល់
Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // សម្រាប់ Admin ដែលមិនទាន់ Login
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);

        Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AdminAuthController::class, 'register']);
    });

    // សម្រាប់ Admin ដែលបាន Login រួច
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});