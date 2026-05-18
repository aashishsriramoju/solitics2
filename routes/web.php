<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SoilController;
use Illuminate\Support\Facades\Route;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::get('/',          fn () => view('welcome'))->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);

    Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Language switcher (public)
Route::post('/language', [ProfileController::class, 'setLanguage'])->name('language.set');

// ── Authenticated routes ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Soil Analysis
    Route::get('/upload',              [SoilController::class, 'showUpload'])->name('soil.upload');
    Route::post('/upload',             [SoilController::class, 'store'])->name('soil.store');
    Route::get('/analysis/{soilReport}', [SoilController::class, 'analysis'])->name('soil.analysis');
    Route::delete('/analysis/{soilReport}', [SoilController::class, 'destroy'])->name('soil.destroy');

    // Reports history
    Route::get('/reports',                     [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/{soilReport}',         [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{soilReport}/pdf',     [ReportController::class, 'downloadPdf'])->name('reports.pdf');

    // Market prices
    Route::get('/markets', [MarketController::class, 'index'])->name('markets');

    // Profile / Settings
    Route::get('/profile',            [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile',            [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',   [ProfileController::class, 'changePassword'])->name('profile.password');
});
