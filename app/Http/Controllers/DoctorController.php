<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoctorController extends Controller
{
    public function getAppointments(Request $request, Doctor $doctor)
    {
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        return response(['success' => true, 'data' => $appointments]);
    }

    public function getAppointment(Request $request, Doctor $doctor, Appointment $appointment)
    {
        if ($doctor->id !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access.']);
        }

        return response(['success' => true, 'data' => $appointment]);
    }

    public function confirmAppointment(Request $request, Doctor $doctor, Appointment $appointment)
    {
        if ($doctor->id !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access resource'], 403);
        }

        $appointment->status = 'scheduled';
        $appointment->save();

        return response([
            'success' => true,
            'message' => 'Appointment confirmed successfully.',
            'data' => $appointment
        ]);
    }

    public function rescheduleAppointment(Request $request, Doctor $doctor, Appointment $appointment)
    {
        // Needs revisiting :(

        $validated = $request->validate(['new_schedule' => 'required|date_format:Y-m-d H:i:s']);

        if (!$doctor || !$appointment) {
            return response(['success' => false, 'message' => 'Appointment or Doctor not found'], 404);
        }

        if ($doctor->id !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access resource'], 403);
        }

        $newSchedule = Carbon::parse($validated['new_schedule']);
        $appointment->scheduled_at = $newSchedule;

        if ($appointment->save()) {
            return response([
                'success' => true,
                'message' => 'Appointment rescheduled successfully.',
                'data' => $appointment
            ]);
        } else {
            return response(['success' => false, 'message' => 'Error saving appointment.'], 500);
        }
    }

    public function declineAppointment(Request $request, Doctor $doctor, Appointment $appointment) {}

    public function cancelAppointment(Request $request, Doctor $doctor, Appointment $appointment)
    {
        if ($doctor->id !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'Unauthorized to access resource'], 403);
        }

        $appointment->status = 'canceled';
        $appointment->save();

        return response([
            'success' => true,
            'message' => 'Appointment canceled.',
            'data' => $appointment
        ]);
    }

    public function markAppointmentAsCompleted(Request $request, Doctor $doctor, Appointment $appointment)
    {
        if ($doctor->id !== $appointment->doctor_id) {
            return response(['success' => false, 'message' => 'UnAuthorized to access resource'], 403);
        }

        $appointment->status = 'completed';
        $appointment->save();

        return response(['success' => true, 'message' => 'Appointment completed.', 'data' => $appointment]);
    }
}
