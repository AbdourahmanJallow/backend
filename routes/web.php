<?php

use App\Http\Controllers\DiseasePredictionController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Middleware\IsPatient;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('auth/register', [PatientController::class, 'create']);
Route::get('auth/login', [PatientController::class, 'loginForm'])->name('login');
Route::post('patient/register', [PatientController::class, 'register'])->name('patient.register');
Route::post('patient/login', [PatientController::class, 'login'])->name('patient.login');

Route::middleware(['auth:web', IsPatient::class])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home');
    });
    Route::get('/disease-predictor', [DiseasePredictionController::class, 'diseasePredictor']);
    Route::post('/predict-disease', [DiseasePredictionController::class, 'predictDisease']);

    Route::get('patient-profile', [PatientController::class, 'profile']);

    Route::post('patient/logout', [PatientController::class, 'logout']);
    Route::put('patient/updateProfile', [PatientController::class, 'updateProfile']);

    Route::apiResource('patientsAppointments', PatientAppointmentController::class);
    Route::apiResource('doctors', DoctorController::class)->only('index', 'show');
});
