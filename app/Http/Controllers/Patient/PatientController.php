<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    public function bookAppointment(StoreAppointmentRequest $request)
    {
        $user = $request->user();
        $user->load('patient');

        $appointment = Appointment::create([
            'patient_id' => $user->patient->id,
            'doctor_id' => $request->doctor_id,
            'reasons' => $request->reasons,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return response(['success' => true, 'data' => $appointment]);
    }

    public function deleteAppointment(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $user->load('patient');

        if ($user->patient->id !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Cannot delete appointment.'], 403);
        }

        $appointment->delete();

        return response(['success' => true, 'message' => 'Appointment deleted successfully.']);
    }

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $user->load('patient');

        if ($user->patient->id !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Cannot delete appointment.'], 403);
        }

        $appointment->status = 'canceled';
        $appointment->save();

        // return response(['success' => false, 'message' => 'Appointment canceled successfully.', 'data' => $appointment]);
        return $appointment;
    }


    public function getMyAppointments(Request $request)
    {
        $user = $request->user();
        $user->load('patient');

        $appointments = Appointment::where('patient_id', $user->patient->id)->get();

        return $appointments;
    }

    public function getAppointment(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $user->load('patient');

        if ($user->patient->id !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Cannot read apppointment.'], 403);
        }

        return $appointment;
    }
}
