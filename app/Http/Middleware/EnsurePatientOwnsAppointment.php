<?php

namespace App\Http\Middleware;

use App\Models\Appointment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePatientOwnsAppointment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $user->load('patient');

        $appointment = $request->route('appointment');

        if ($user->patient->id !== $appointment->patient_id) {
            return response(['success' => false, 'message' => 'Cannot delete appointment.'], 403);
        }

        return $next($request);
    }
}
