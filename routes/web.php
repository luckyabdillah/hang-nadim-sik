<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index']);

Route::get('dashboard/users', [UserController::class, 'index']);
Route::get('dashboard/users/create', [UserController::class, 'create']);
Route::post('dashboard/users', [UserController::class, 'store']);
Route::get('dashboard/users/{user}/edit', [UserController::class, 'edit']);
Route::put('dashboard/users/{user}', [UserController::class, 'update']);
Route::delete('dashboard/users/{user}', [UserController::class, 'destroy']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);