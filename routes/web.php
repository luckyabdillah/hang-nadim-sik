<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CopyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index']);

Route::get('dashboard/copies', [CopyController::class, 'index']);
Route::get('dashboard/copies/create', [CopyController::class, 'create']);
Route::post('dashboard/copies', [CopyController::class, 'store']);
Route::get('dashboard/copies/{copy}/edit', [CopyController::class, 'edit']);
Route::put('dashboard/copies/{copy}', [CopyController::class, 'update']);
Route::delete('dashboard/copies/{copy}', [CopyController::class, 'destroy']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);