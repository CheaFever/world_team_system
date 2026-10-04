<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

// បញ្ជូនពីទំព័រដើម (Root URL) ទៅកាន់ទំព័រ Login របស់ Admin ដោយស្វ័យប្រវត្តិ
Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // សម្រាប់ Admin ដែលមិនទាន់ Login (ការពារមិនឱ្យ Admin ដែល Login រួចចូលទំព័រនេះទៀត)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

        Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
    });

    // សម្រាប់ Admin ដែលបាន Login រួច (Protected Routes)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
         // --- ROUTES សម្រាប់ PROFILE ---
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [AdminAuthController::class, 'updateProfile'])->name('profile.update');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    });
});
use App\Http\Controllers\MeetingSundayController;

Route::resource('meeting-sunday', MeetingSundayController::class);
