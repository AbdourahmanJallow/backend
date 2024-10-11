<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsPatient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('auth/register', [PatientController::class, 'create']);
Route::get('auth/login', [PatientController::class, 'loginForm'])->name('login');
Route::post('patient/register', [PatientController::class, 'register'])->name('patient.register');
Route::post('patient/login', [PatientController::class, 'login'])->name('patient.login');

Route::middleware(['auth:web', IsPatient::class])->group(function () {
    Route::get('/', [DoctorController::class, 'index']);

    Route::get('patient-profile', [PatientController::class, 'profile']);
    Route::get('doctors/{doctor}', function (Doctor $doctor) {
        $doctor->load('user');
        return Inertia::render('DoctorDetails', ['doctor' => $doctor]);
    });

    Route::post('patient/logout', [PatientController::class, 'logout']);
    Route::put('patient/updateProfile', [PatientController::class, 'updateProfile']);

    Route::apiResource('patientsAppointments', PatientAppointmentController::class);
});
