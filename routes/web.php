<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\VendorController;
use App\Http\Controllers\Dashboard\WorkTypeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index']);

Route::get('dashboard/vendors', [VendorController::class, 'index']);
Route::get('dashboard/vendors/create', [VendorController::class, 'create']);
Route::post('dashboard/vendors', [VendorController::class, 'store']);
Route::get('dashboard/vendors/{vendor}/edit', [VendorController::class, 'edit']);
Route::put('dashboard/vendors/{vendor}', [VendorController::class, 'update']);
Route::delete('dashboard/vendors/{vendor}', [VendorController::class, 'destroy']);

Route::get('dashboard/work-types', [WorkTypeController::class, 'index']);
Route::get('dashboard/work-types/create', [WorkTypeController::class, 'create']);
Route::post('dashboard/work-types', [WorkTypeController::class, 'store']);
Route::get('dashboard/work-types/{type}/edit', [WorkTypeController::class, 'edit']);
Route::put('dashboard/work-types/{type}', [WorkTypeController::class, 'update']);
Route::delete('dashboard/work-types/{type}', [WorkTypeController::class, 'destroy']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);