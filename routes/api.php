<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    $user = $request->user();
    $user->userType === 'patient' ? $user->load('patient') : $user->userType === 'doctor' &&
        $user->load('doctor');

    return $user;
})->middleware('auth:sanctum');

// Patient Authentication
Route::post('patient/register', [PatientController::class, 'register']);
Route::post('patient/login', [PatientController::class, 'login']);

// Doctor Authentication
Route::post('doctor/register', [DoctorController::class, 'register']);
Route::post('doctor/login', [DoctorController::class, 'login']);

Route::middleware('auth:sanctum',)->group(function () {
    Route::post('patient/logout', [PatientController::class, 'logout']);
    Route::put('patient/updateProfile', [PatientController::class, 'updateProfile']);

    Route::post('doctor/logout', [DoctorController::class, 'logout']);
    Route::put('doctor/updateProfile', [DoctorController::class, 'updateProfile']);
    Route::get('doctor/profile', [DoctorController::class, 'profile']);

    Route::apiResources([
        'patientsAppointments' => PatientAppointmentController::class,
        'doctorsAppointments' => DoctorAppointmentController::class
    ]);
});

// Admin routes
Route::post('admin/register', [AdminController::class, 'register'])->name('register');
Route::post('admin/login', [AdminController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum', IsAdmin::class])->group(function () {
    Route::post('admin/logout', [AdminController::class, 'logout']);
    Route::get('admin/patients', [AdminController::class, 'getPatients']);
    Route::get('admin/doctors', [AdminController::class, 'getDoctors']);
    Route::get('admin/appointments', [AdminController::class, 'getAppointments']);
    Route::get('admin/appointments/{appointment}', [AdminController::class, 'getAppointment']);
    Route::delete('admin/users/{user}/delete', [AdminController::class, 'destroyUser']);
    Route::put('admin/users/{user}/update', [AdminController::class, 'updateUser']);
});
