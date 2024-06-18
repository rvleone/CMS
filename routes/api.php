<?php

use App\Http\Controllers\Admin\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/imageupload', [UploadController::class, 'imageupload'])->name('imageupload');
