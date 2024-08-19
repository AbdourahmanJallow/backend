<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// User (Doctor and Patient) Routes
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);

Route::middleware('auth:sanctum',)->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Admin routes
Route::post('admin/login', [AdminController::class, 'login'])->name('login');
Route::post('admin/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', IsAdmin::class])->group(function () {
    Route::get('admin/patients', [AdminController::class, 'getPatients']);
    Route::get('admin/doctors', [AdminController::class, 'getDoctors']);
    Route::delete('admin/users/{user}/delete', [AdminController::class, 'destroyUser']);
    Route::put('admin/users/{user}/update', [AdminController::class, 'updateUser']);
});
