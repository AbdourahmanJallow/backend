<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function bookAppointment(StoreAppointmentRequest $request, Patient $patient)
    {
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'reasons' => $request->reasons,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return response(['success' => true, 'data' => $appointment]);
    }

    public function deleteAppointment(Request $request, Patient $patient, Appointment $appointment)
    {
        if ($patient->id !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access route.'], 403);
        }

        $appointment->delete();

        return response(['success' => true, 'message' => 'Appointment deleted successfully.']);
    }

    public function cancelAppointment(Request $request, Patient $patient, Appointment $appointment)
    {
        if ($patient->id !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access route'], 403);
        }

        if ($appointment->status === 'canceled') {
            return response(['success' => false, 'message' => 'Appointment already canceled.']);
        }

        $appointment->status = 'canceled';
        $appointment->save();

        return response(['success' => true, 'message' => 'Appointment canceled successfully.', 'data' => $appointment]);
    }

    public function rescheduleAppointment(Request $request, Appointment $appointment)
    {
        // Needs revisit
        $validated = $request->validate(['new_schedule' => 'required|date_format:Y-m-d H:i:s']);

        $appointment->scheduled_at = $request->new_schedule;
        $appointment->save();

        return response([
            'success' => true,
            'message' => 'Appointment rescheduled successfully.',
            'data' => $appointment
        ]);
    }

    public function getMyAppointments(Request $request, Patient $patient)
    {
        $appointments = Appointment::where('patient_id', $patient->id)->get();

        return $appointments;
    }

    public function getAppointment(Request $request, Patient $patient, Appointment $appointment)
    {
        if ($patient->id !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Cannot read apppointment.'], 403);
        }

        return $appointment;
    }
}
