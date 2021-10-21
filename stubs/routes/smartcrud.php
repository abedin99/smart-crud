<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::name('smartcrud.')->prefix('smartcrud')->group(function () {
    // define all backend route
    Route::get('/', function () {
        return redirect()->route('smartcrud.login');
    });

    Route::get('/register', [RegisteredUserController::class, 'create'])
                    ->middleware('smartcrud')
                    ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
                    ->middleware('smartcrud');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                    ->middleware('smartcrud')
                    ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                    ->middleware('smartcrud');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                    ->middleware('smartcrud')
                    ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                    ->middleware('smartcrud')
                    ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                    ->middleware('smartcrud')
                    ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
                    ->middleware('smartcrud')
                    ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                    ->middleware('auth:smartcrud')
                    ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                    ->middleware(['auth:smartcrud', 'signed', 'throttle:6,1'])
                    ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                    ->middleware(['auth:smartcrud', 'throttle:6,1'])
                    ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                    ->middleware('auth:smartcrud')
                    ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                    ->middleware('auth:smartcrud');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->middleware('auth:smartcrud')
                    ->name('logout');
                               
    Route::middleware(['auth:smartcrud', 'verified:smartcrud.verification.notice'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    });
});