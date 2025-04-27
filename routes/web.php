<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\WorkLocationController;
use App\Http\Controllers\Dashboard\CopyController;
use App\Http\Controllers\Dashboard\ApproverController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\VendorController;
use App\Http\Controllers\Dashboard\WorkTypeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    
    Route::resource('copies', CopyController::class)->except(['show'])->names('dashboard.copies');
    Route::resource('work-types', WorkTypeController::class)->except(['show'])->parameters(['work-types' => 'type'])->names('dashboard.work-types');
    Route::resource('work-locations', WorkLocationController::class)->except(['show'])->parameters(['work-locations' => 'location'])->names('dashboard.work-locations');

    Route::resource('vendors', VendorController::class)->except(['show'])->names('dashboard.vendors');
    
    Route::resource('approvers', ApproverController::class)->except(['show'])->names('dashboard.approvers');
    Route::resource('users', UserController::class)->except(['show'])->names('dashboard.users');
});


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);