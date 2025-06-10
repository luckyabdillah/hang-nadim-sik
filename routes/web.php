<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SinglePageController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\WorkLocationController;
use App\Http\Controllers\Dashboard\LetterFundamentalController;
use App\Http\Controllers\Dashboard\CopyController;
use App\Http\Controllers\Dashboard\ApproverController;
use App\Http\Controllers\Dashboard\ApplicantController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WorkPermitLetterController;
use App\Http\Controllers\Dashboard\ApprovalController;
use App\Http\Controllers\Dashboard\VendorController;
use App\Http\Controllers\Dashboard\RegistrationController;
use App\Http\Controllers\Dashboard\WorkTypeController;
use App\Http\Controllers\Dashboard\My\DashboardController as MyDashboardController;
use App\Http\Controllers\Dashboard\My\WorkPermitLetterController as MyWorkPermitLetterController;
use App\Http\Controllers\Dashboard\My\UserController as MyUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('/', [SinglePageController::class, 'index']);
Route::get('/sik', [SinglePageController::class, 'sik']);
Route::get('/contact', [SinglePageController::class, 'contact']);

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    
    Route::resource('copies', CopyController::class)->except(['show'])->names('dashboard.copies');
    Route::resource('work-types', WorkTypeController::class)->except(['show'])->parameters(['work-types' => 'type'])->names('dashboard.work-types');
    Route::resource('work-locations', WorkLocationController::class)->except(['show'])->parameters(['work-locations' => 'location'])->names('dashboard.work-locations');
    Route::resource('letter-fundamentals', LetterFundamentalController::class)->except(['show'])->parameters(['letter-fundamentals' => 'fundamental'])->names('dashboard.letter-fundamentals');

    Route::resource('work-permit-letters', WorkPermitLetterController::class)->except(['create', 'store', 'edit'])->parameters(['work-permit-letters' => 'letter'])->names('dashboard.work-permit-letters');
    Route::get('work-permit-letters/{letter}/export-pdf', [WorkPermitLetterController::class, 'exportPDF'])->name('dashboard.work-permit-letters.export-pdf');
    Route::resource('approvals', ApprovalController::class)->except(['create', 'store', 'edit'])->parameters(['approvals' => 'stage'])->names('dashboard.approvals');
    Route::resource('vendors', VendorController::class)->except(['show'])->names('dashboard.vendors');
    Route::resource('registrations', RegistrationController::class)->only(['index', 'edit', 'update'])->names('dashboard.registrations');
    
    Route::resource('approvers', ApproverController::class)->except(['show'])->names('dashboard.approvers');
    Route::resource('applicants', ApplicantController::class)->only(['index', 'show'])->names('dashboard.applicants');
    Route::resource('users', UserController::class)->except(['show'])->names('dashboard.users');

    Route::get('work-types/trashed', [WorkTypeController::class, 'trashed'])->name('dashboard.work-types.trashed');
    Route::post('work-types/recover-all', [WorkTypeController::class, 'recoverAll'])->name('dashboard.work-types.recoverAll');
    Route::put('work-types/{id}/recover', [WorkTypeController::class, 'recover'])->name('dashboard.work-types.recover');
    Route::delete('work-types/{id}/force', [WorkTypeController::class, 'forceDelete'])->name('dashboard.work-types.forceDelete');

    Route::get('work-locations/trashed', [WorkLocationController::class, 'trashed'])->name('dashboard.work-locations.trashed');
    Route::post('work-locations/recover-all', [WorkLocationController::class, 'recoverAll'])->name('dashboard.work-locations.recoverAll');
    Route::put('work-locations/{id}/recover', [WorkLocationController::class, 'recover'])->name('dashboard.work-locations.recover');
    Route::delete('work-locations/{id}/force', [WorkLocationController::class, 'forceDelete'])->name('dashboard.work-locations.forceDelete');

    Route::get('vendors/trashed', [VendorController::class, 'trashed'])->name('dashboard.vendors.trashed');
    Route::post('vendors/recover-all', [VendorController::class, 'recoverAll'])->name('dashboard.vendors.recoverAll');
    Route::put('vendors/{id}/recover', [VendorController::class, 'recover'])->name('dashboard.vendors.recover');
    Route::delete('vendors/{id}/force', [VendorController::class, 'forceDelete'])->name('dashboard.vendors.forceDelete');
});

Route::prefix('dashboard/my')->group(function () {
    Route::get('/', [MyDashboardController::class, 'index']);
    
    Route::resource('work-permit-letters', MyWorkPermitLetterController::class)->except(['edit'])->parameters(['work-permit-letters' => 'letter'])->names('dashboard.my.work-permit-letters');
    Route::resource('users', MyUserController::class)->except(['show'])->names('dashboard.my.users');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');