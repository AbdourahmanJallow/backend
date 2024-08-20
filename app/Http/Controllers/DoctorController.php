<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function getAppointments(Request $request)
    {
        $user = $request->user();
        $user->load('doctor');

        $appointments = Appointment::where('doctor_id', $user->doctor->id)->get();

        return response(['success' => true, 'data' => $appointments]);
    }


    public function getAppointment(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $user->load('doctor');

        if ($user->doctor->id !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'Cannot read appointment.']);
        }

        return response(['success' => true, 'data' => $appointment]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
