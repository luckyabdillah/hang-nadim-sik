<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\WorkLocationController;
use App\Http\Controllers\Dashboard\CopyController;
use App\Http\Controllers\Dashboard\ApproverController;
use App\Http\Controllers\Dashboard\ApplicantController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WorkPermitLetterController;
use App\Http\Controllers\Dashboard\ApprovalController;
use App\Http\Controllers\Dashboard\VendorController;
use App\Http\Controllers\Dashboard\RegistrationController;
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

    Route::resource('work-permit-letters', WorkPermitLetterController::class)->except(['create', 'store', 'edit'])->parameters(['work-permit-letters' => 'letter'])->names('dashboard.work-permit-letters');
    Route::resource('approvals', ApprovalController::class)->except(['create', 'store', 'edit'])->parameters(['approvals' => 'stage'])->names('dashboard.approvals');
    Route::resource('vendors', VendorController::class)->except(['show'])->names('dashboard.vendors');
    Route::resource('registrations', RegistrationController::class)->only(['index', 'edit', 'update'])->names('dashboard.registrations');
    
    Route::resource('approvers', ApproverController::class)->except(['show'])->names('dashboard.approvers');
    Route::resource('applicants', ApplicantController::class)->only(['index', 'show'])->names('dashboard.applicants');
    Route::resource('users', UserController::class)->except(['show'])->names('dashboard.users');
});


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);