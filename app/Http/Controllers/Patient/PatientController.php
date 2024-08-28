<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function register(StorePatientRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create([
            'name' => $validatedData['name'],
            // 'phoneNumber' => $validatedData['phoneNumber'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            "userType" => 'patient'
        ]);

        Patient::create([
            'user_id' => $user->id,
        ]);

        return response($user, 200);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email',],
            'password' => ['required', 'min:8'],
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response("Invalid credentials", 403);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response([
            "success" => true,
            "token" => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['success' => true, 'message' => 'User logged out successfully.']);
    }


    public function updateProfile(Request $request)
    {
        if ($request->email || $request->password) {
            return response(['success' => false, 'message' => 'Cannot phone or password.']);
        }

        $doctorId = auth()->user()->doctor()->id;

        return response(['message' => 'Profile updated successfully.', 'dotor' => $doctorId]);
    }
}
