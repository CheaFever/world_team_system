<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\EventController;

// ជម្រើសទី ១៖ ប្រើប្រាស់ Route Resource (បង្កើត routes ទាំងអស់៖ index, create, store, show, edit, update, destroy តែម្ដង)
Route::resource('events', EventController::class);

// (ប្រសិនបើចង់ការពារដោយ Login អាចប្រើ middleware auth):
// Route::middleware(['auth'])->group(function () {
//     Route::resource('events', EventController::class);
// });