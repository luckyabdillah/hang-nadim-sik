<?php

use App\Http\Controllers\Api\CopyController;
use App\Http\Controllers\Api\WorkTypeController;
use App\Http\Controllers\Api\WorkLocationController;
use App\Http\Controllers\Api\LetterFundamentalController;
use App\Http\Controllers\Api\WorkPermitLetterController;
use App\Http\Controllers\Api\ApprovalController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ApproverController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // JWT based API auth (v1)
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot', [AuthController::class, 'forgotPassword']);
        Route::post('reset', [AuthController::class, 'resetPassword']);

        Route::middleware('auth:api')->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });

    Route::apiResource('copies', CopyController::class)->names('api.copies');
    Route::apiResource('work-types', WorkTypeController::class)->parameters(['work-types' => 'type'])->names('api.work-types');
    Route::apiResource('work-locations', WorkLocationController::class)->parameters(['work-locations' => 'location'])->names('api.work-locations');
    Route::apiResource('letter-fundamentals', LetterFundamentalController::class)->parameters(['letter-fundamentals' => 'fundamental'])->names('api.letter-fundamentals');
    
    Route::apiResource('work-permit-letters', WorkPermitLetterController::class)->parameters(['work-permit-letters' => 'letter'])->names('api.work-permit-letters');
    Route::apiResource('approvals', ApprovalController::class)->parameters(['approvals' => 'stage'])->names('api.approvals');
    
    Route::apiResource('vendors', VendorController::class)->names('api.vendors');
    Route::apiResource('approvers', ApproverController::class)->names('api.approvers');
});
