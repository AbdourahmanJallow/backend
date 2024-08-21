<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middleware\EnsurePatientOwnsAppointment;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    $user = $request->user();
    $user->userType === 'patient' ? $user->load('patient') : $user->userType === 'doctor' &&
        $user->load('doctor');

    return $user;
})->middleware('auth:sanctum');

// User (Doctor and Patient) Authentication
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::middleware('auth:sanctum',)->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::post('patients/{patient}/book-appointment', [PatientController::class, 'bookAppointment']);
    Route::get('patients/{patient}/appointments', [PatientController::class, 'getMyAppointments']);
    Route::get('patients/{patient}/appointments/{appointment}', [PatientController::class, 'getAppointment']);
    Route::put('patients/{patient}/appointments/{appointment}/cancel', [PatientController::class, 'cancelAppointment']);
    Route::delete('patients/{patient}/appointments/{appointment}/delete', [PatientController::class, 'deleteAppointment']);

    Route::get('doctors/{doctor}/appointments', [DoctorController::class, 'getAppointments']);
    Route::get('doctors/{doctor}/appointments/{appointment}', [DoctorController::class, 'getAppointment']);
    Route::put('doctors/{doctor}/appointments/{appointment}/confirm', [DoctorController::class, 'confirmAppointment']);
    Route::put('doctors/{doctor}/appointments/{appointment}/reschedule', [DoctorController::class, 'rescheduleAppointment']);
    Route::put('doctors/{doctor}/appointments/{appointment}/cancel', [DoctorController::class, 'cancelAppointment']);
    Route::put('doctors/{doctor}/appointments/{appointment}/completed', [DoctorController::class, 'markAppointmentAsCompleted']);
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
