<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $appointments = Appointment::with(['doctor.user'])->where('patient_id', $this->getPatientId($request))->get();

        // return $appointments;
        return Inertia::render('Appointments', ['appointments' => $appointments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $scheduled_at = Carbon::parse($request->date . ' ' . $request->time);

        Appointment::create([
            'patient_id' => $this->getPatientId($request),
            'doctor_id' => $request->doctor_id,
            'reasons' => $request->reasons,
            'scheduled_at' => $scheduled_at,
        ]);

        session()->flash('success', 'Appointment created successfully.');

        // return response(['success' => true, 'data' => $appointment]);
        // return redirect()->route('patientsAppointments.index')->with('success', 'Appointment booked successfully!');

        // return Inertia::location(route('patientsAppointments.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($this->getPatientId($request) !== $appointment->first()->patient_id) {
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

        if ($this->getPatientId($request) !== $appointment->patient_id) {
            return response(['message' => 'Unauthorized to access resource'], 403);
        }

        if ($request->reasons) {
            $appointment->reasons = $request->reasons;
        }

        if ($request->statusUpdate) {
            $appointment->status = 'canceled';
        }

        $appointment->save();

        return redirect()->back()->with(
            'flash',
            [
                'message' => 'Appointment updated successfully.',
                'data' => $appointment
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($this->getPatientId($request) !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access route.'], 403);
        }

        $appointment->delete();

        return response(['success' => true, 'message' => 'Appointment deleted successfully.']);
    }

    private function getPatientId(Request $request)
    {
        return $request->user()->patient()->first()->id;
    }
}
