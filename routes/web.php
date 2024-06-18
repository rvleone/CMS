<?php

use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('painel')->group(function () {
    Route::get('/', [HomeAdminController::class, 'index'])->name('admin')->middleware('auth:sanctum');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.create');
    Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth:sanctum');
    Route::resource('/users', UserController::class)->middleware(['auth:sanctum', 'can:edit-users']);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth:sanctum');
    Route::put('/profilesave', [ProfileController::class, 'save'])->name('profile.save')->middleware('auth:sanctum');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings')->middleware('auth:sanctum');
    Route::put('/settingssave', [SettingController::class, 'save'])->name('settings.save')->middleware('auth:sanctum');
    Route::resource('/pages', PageController::class)->middleware(['auth:sanctum']);
});
