<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\WorkLocationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index']);

Route::get('dashboard/work-locations', [WorkLocationController::class, 'index']);
Route::get('dashboard/work-locations/create', [WorkLocationController::class, 'create']);
Route::post('dashboard/work-locations', [WorkLocationController::class, 'store']);
Route::get('dashboard/work-locations/{location}/edit', [WorkLocationController::class, 'edit']);
Route::put('dashboard/work-locations/{location}', [WorkLocationController::class, 'update']);
Route::delete('dashboard/work-locations/{location}', [WorkLocationController::class, 'destroy']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);