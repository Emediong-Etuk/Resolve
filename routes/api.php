<?php

use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Auth\TwoFactorController;
use App\Http\Controllers\User\Profile\ProfileController;
use App\Http\Controllers\Workspace\WorkspaceController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function(){
    Route::post('/signup','signup')->middleware('throttle:signup');
    Route::post('/verify-email','verifyEmail')->middleware('throttle:token');
    Route::post('/login','login')->middleware('throttle:login');
    Route::post('/logout','logout')->middleware('auth:sanctum');
    Route::post('/forgot-password','forgotPassword')->middleware('throttle:forgot-password');
    Route::post('/reset-password','resetPassword')->middleware('throttle:token');
    Route::post('/two-factor-challenge','twoFactorChallenge')->middleware('throttle:api-two-factor');
});

Route::middleware('auth:sanctum')->prefix('/user')->controller(TwoFactorController::class)->group(function(){
     Route::post('/two-factor-authentication', 'enable');
        Route::post('/confirmed-two-factor-authentication', 'confirm');
        Route::post('/two-factor-recovery-codes', 'regenerateRecoveryCodes');
        Route::delete('/two-factor-authentication', 'disable');
});

Route::controller(ProfileController::class)->middleware('auth:sanctum')->prefix('/profile')->group(function(){
    Route::get('/view','view');
    Route::post('/image/upload','uploadImage');
});

Route::controller(WorkspaceController::class)->middleware('auth:sanctum')->prefix('/workspace')->group(function(){
    Route::post('/create','create');
    Route::get('/view/all','viewAll');
    Route::get('/{workspace}/view','view');
    Route::post('/{workspace}/update','update');
    Route::delete('/{workspace}/delete','delete');
    Route::post('{workspace}/logo/upload','uploadLogo');
});



