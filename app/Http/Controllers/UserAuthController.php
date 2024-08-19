<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Validation\Rules;


class UserAuthController extends Controller
{
    // use HasApiTokens

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8',],
            "userType" => ["required", 'in:patient,doctor,admin'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            "userType" => $validatedData['userType']
        ]);

        if ($user->userType === 'patient') {
            $patient = Patient::create([
                'user_id' => $user->id,
                'phoneNumber' => $request->phoneNumber,
                "dateOfBirth" => $request->dateOfBirth,
                // "address" => $request->address,
                // "medicalHistory" => $request->medicalHistory,
            ]);
        } elseif ($user->userType === 'doctor') {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'specialization' => $request->specialization,
                "clinicalAddress" => $request->clinicalAddress,
                "yearsOfExperience" => $request->yearsOfExperience,
            ]);
        }

        $user->load("patient", 'doctor');
        // event(new Registered($user));

        return response($user, 200);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'string',],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response("Invalid credentials", 403);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response(["success" => true, "token" => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['success' => true, 'message' => 'User logged out successfully.']);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
