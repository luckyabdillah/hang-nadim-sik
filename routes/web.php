<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SinglePageController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\WorkLocationController;
use App\Http\Controllers\Dashboard\LetterFundamentalController;
use App\Http\Controllers\Dashboard\CopyController;
use App\Http\Controllers\Dashboard\ApproverController;
use App\Http\Controllers\Dashboard\ApplicantController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WorkPermitLetterController;
use App\Http\Controllers\Dashboard\ApprovalController;
use App\Http\Controllers\Dashboard\VendorController;
use App\Http\Controllers\Dashboard\RegistrationController;
use App\Http\Controllers\Dashboard\WorkTypeController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\My\DashboardController as MyDashboardController;
use App\Http\Controllers\Dashboard\My\WorkPermitLetterController as MyWorkPermitLetterController;
use App\Http\Controllers\Dashboard\My\UserController as MyUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ChangeablePasswordController;

Route::get('/', [SinglePageController::class, 'index']);
Route::get('/contact', [SinglePageController::class, 'contact']);
Route::post('/contact', [SinglePageController::class, 'storeContact']);
    
Route::get('/register/info', [RegisterController::class, 'info']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware(['auth', 'type'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        Route::middleware(['permission'])->group(function () {
            Route::resource('copies', CopyController::class)->except(['show'])->names('dashboard.copies');
            Route::resource('work-types', WorkTypeController::class)->except(['show'])->parameters(['work-types' => 'type'])->names('dashboard.work-types');
            Route::resource('work-locations', WorkLocationController::class)->except(['show'])->parameters(['work-locations' => 'location'])->names('dashboard.work-locations');
            Route::resource('letter-fundamentals', LetterFundamentalController::class)->except(['show'])->parameters(['letter-fundamentals' => 'fundamental'])->names('dashboard.letter-fundamentals');
        
            Route::get('work-permit-letters/export-excel', [WorkPermitLetterController::class, 'exportExcel'])->name('dashboard.work-permit-letters.export-excel');
            Route::resource('work-permit-letters', WorkPermitLetterController::class)->except(['create', 'store', 'edit'])->parameters(['work-permit-letters' => 'letter'])->names('dashboard.work-permit-letters');
            Route::get('work-permit-letters/{letter}/export-pdf', [WorkPermitLetterController::class, 'exportPDF'])->name('dashboard.work-permit-letters.export-pdf');
            Route::put('work-permit-letters/{letter}/completion', [WorkPermitLetterController::class, 'updateCompletion'])->name('dashboard.work-permit-letters.completion');
            Route::resource('approvals', ApprovalController::class)->except(['create', 'store', 'edit'])->parameters(['approvals' => 'stage'])->names('dashboard.approvals');
            Route::resource('vendors', VendorController::class)->except(['create', 'show', 'destroy'])->names('dashboard.vendors');
            Route::resource('registrations', RegistrationController::class)->only(['index', 'edit', 'update'])->names('dashboard.registrations');
            
            Route::resource('approvers', ApproverController::class)->except(['show'])->names('dashboard.approvers');
        
            Route::get('work-types/trashed', [WorkTypeController::class, 'trashed'])->name('dashboard.work-types.trashed');
            Route::post('work-types/recover-all', [WorkTypeController::class, 'recoverAll'])->name('dashboard.work-types.recoverAll');
            Route::put('work-types/{id}/recover', [WorkTypeController::class, 'recover'])->name('dashboard.work-types.recover');
        
            Route::get('work-locations/trashed', [WorkLocationController::class, 'trashed'])->name('dashboard.work-locations.trashed');
            Route::post('work-locations/recover-all', [WorkLocationController::class, 'recoverAll'])->name('dashboard.work-locations.recoverAll');
            Route::put('work-locations/{id}/recover', [WorkLocationController::class, 'recover'])->name('dashboard.work-locations.recover');
    
            Route::prefix('user-management')->group(function () {
                Route::resource('permissions', PermissionController::class)->except(['create', 'show', 'edit'])->names('dashboard.permissions');
                Route::resource('roles', RoleController::class)->names('dashboard.roles');
                Route::resource('users', UserController::class)->except(['show'])->names('dashboard.users');
            });
        });
    
        Route::get('/profile', [ProfileController::class, 'edit']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::put('/approver-details', [ProfileController::class, 'updateApprover']);
    });
    
    Route::prefix('dashboard/my')->group(function () {
        Route::get('/', [MyDashboardController::class, 'index']);
        
        Route::resource('work-permit-letters', MyWorkPermitLetterController::class)->except(['edit'])->parameters(['work-permit-letters' => 'letter'])->names('dashboard.my.work-permit-letters');
        Route::get('work-permit-letters/{letter}/export-pdf', [WorkPermitLetterController::class, 'exportPDF'])->name('dashboard.work-permit-letters.export-pdf');
    });
    
    Route::put('change-password', [ChangeablePasswordController::class, 'update']);
    Route::post('logout', [LoginController::class, 'logout']);
});

Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});
