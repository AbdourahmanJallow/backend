<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

use function Pest\Laravel\get;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::with('user');

        $search = $request->query('search');
        if ($request->has('search')) {

            $doctors = $doctors->when($search, function ($query) use ($search) {
                $query->where('specialization', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $doctors = $doctors->orderBy('created_at')->paginate(8);

        return Inertia::render('Doctors', props: ['doctors' => $doctors, 'search' => $search ?? '']);
    }

    public function show(Request $request, Doctor $doctor)
    {
        if (!$doctor) return 'No Doctor found.';

        $doctor->load('user');
        return Inertia::render('DoctorDetails', ['doctor' => $doctor]);
    }

    public function profile(Request $request)
    {
        $user  = $request->user();
        $user->load('doctor');
        $user->doctor->load('availableDates');

        return $user;
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        return response([
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }
}
