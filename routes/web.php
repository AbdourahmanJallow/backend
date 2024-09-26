<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middleware\IsAdmin;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/register-patient', [PatientController::class, 'create']);
Route::get('/login-patient', [PatientController::class, 'loginForm'])->name('login');
Route::post('patient/register', [PatientController::class, 'register'])->name('patient.register');
Route::post('patient/login', [PatientController::class, 'login'])->name('patient.login');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        $doctors = Doctor::all();
        return Inertia::render('Home', ['doctors' => $doctors]);
    });
    Route::get('patient-profile', [PatientController::class, 'profile']);
    Route::get('doctors/{doctor}', function (Doctor $doctor) {
        $doctor->load('user');
        $doctorUserObject = $doctor->user;
        return Inertia::render('DoctorDetails', ['doctor' => $doctor, 'doctorUserObject' => $doctorUserObject]);
    });

    Route::post('patient/logout', [PatientController::class, 'logout']);
    Route::put('patient/updateProfile', [PatientController::class, 'updateProfile']);

    Route::post('doctor/logout', [DoctorController::class, 'logout']);
    Route::put('doctor/updateProfile', [DoctorController::class, 'updateProfile']);
    Route::get('doctor/profile', [DoctorController::class, 'profile']);

    Route::apiResources([
        'patientsAppointments' => PatientAppointmentController::class,
        // 'doctorsAppointments' => DoctorAppointmentController::class
    ]);
});
