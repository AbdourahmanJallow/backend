<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::where('patient_id', $this->getPatientId())->get();

        return $appointments;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create([
            'patient_id' => $this->getPatientId(),
            'doctor_id' => $request->doctor_id,
            'reasons' => $request->reasons,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return response(['success' => true, 'data' => $appointment]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($this->getPatientId() !== $appointment->first()->patient_id) {
            return response(['success' => false, 'message' => 'Cannot read apppointment.'], 403);
        }

        return $appointment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($this->getPatientId() !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access resource'], 403);
        }

        if ($request->reasons) {
            $appointment->reasons = $request->reasons;
        }

        if ($request->cancelAppointment) {
            $appointment->status = 'canceled';
        }

        $appointment->save();

        return response(
            [
                'success' => true,
                'message' => 'Appointment updated successfully.',
                'data' => $appointment
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($this->getPatientId() !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access route.'], 403);
        }

        $appointment->delete();

        return response(['success' => true, 'message' => 'Appointment deleted successfully.']);
    }

    private function getPatientId()
    {
        return auth()->user()->patient()->first()->id;
    }
}
