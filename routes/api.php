<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middleware\EnsurePatientOwnsAppointment;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    $user = $request->user();
    $user->load('patient');
    return $user;
})->middleware('auth:sanctum');

// User (Doctor and Patient) Authentication
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::middleware('auth:sanctum',)->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::post('patient/book-appointment', [PatientController::class, 'bookAppointment']);
    Route::get('patient/appointments', [PatientController::class, 'getMyAppointments']);
    Route::get('patient/appointments/{appointment}', [PatientController::class, 'getAppointment']);
    Route::put('patient/appointments/{appointment}/cancel', [PatientController::class, 'cancelAppointment']);
    Route::delete('patient/appointments/{appointment}/delete', [PatientController::class, 'deleteAppointment']);
});

// Admin routes
Route::post('admin/login', [AdminController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum', IsAdmin::class])->group(function () {
    Route::post('admin/logout', [AdminController::class, 'logout']);
    Route::get('admin/patients', [AdminController::class, 'getPatients']);
    Route::get('admin/doctors', [AdminController::class, 'getDoctors']);
    Route::get('admin/appointments', [AdminController::class, 'getAppointments']);
    Route::delete('admin/users/{user}/delete', [AdminController::class, 'destroyUser']);
    Route::put('admin/users/{user}/update', [AdminController::class, 'updateUser']);
});
