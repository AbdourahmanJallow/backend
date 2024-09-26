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
            Patient::create([
                'user_id' => $user->id,
            ]);

            return redirect()->intended('/');
        } elseif ($user->userType === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
            ]);

            return redirect()->intended('/dashboard');
        }

        // $user->load("patient", 'doctor');
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
        $user->load('patient', 'doctor');

        $id = $user->userType === 'patient' ? $user->patient->id : $user->doctor->id;

        return response([
            "success" => true,
            "token" => $token,
            'userType' => $user->userType,
            'id' => $id
        ], 200);
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
