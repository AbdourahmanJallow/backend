<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::where('doctor_id', $this->getDoctorId())->get();

        return response(['success' => true, 'data' => $appointments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store() {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($this->getDoctorId() !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access resource.']);
        }

        return response(['success' => true, 'data' => $appointment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($this->getDoctorId() !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access resource'], 403);
        }

        if ($request->statusUpdate) {
            $appointment->status = $request->statusUpdate;
        }

        if ($request->newSchedule) {
            $appointment->scheduled_at = Carbon::parse($request->newSchedule);
        }

        $appointment->save();

        return response([
            'success' => true,
            'message' => 'Appointment updated successfully.',
            'data' => $appointment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor) {}

    private function getDoctorId()
    {
        return auth()->user()->doctor()->first()->id;
    }
}
