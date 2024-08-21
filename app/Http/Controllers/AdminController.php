<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "email" => ["required", 'email', 'unique:users'],
            "password" => [
                "required",
                "min:8"
            ],
            "name" => ["required", "string"],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userType' => 'admin'
        ]);

        return response(['success' => true, 'data' => $user]);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", 'email'],
            "password" => [
                "required",
                "min:8"
            ]
        ]);

        if (!Auth::attempt($credentials)) {
            return response(["success" => false, "message" => "Invalid credentials."], 401);
        }

        $user = $request->user();

        if ($user->userType !== 'admin') {
            return response(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $token = $user->createToken('Admin access token')->plainTextToken;

        return response(["success" => true, "message" => "Admin logged in successfully.", "token" => $token,]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response(['success' => true, 'message' => 'Admin logged out successfully.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(Request $request, User $user)
    {
        if (!$user) {
            return response(["success" => false, "message" => "User not found."]);
        }

        $user->delete();

        return response(['success' => true, "message" => "User deleted."]);
    }

    public function getPatients()
    {
        $patients = Patient::all();
        $patients->load('user');

        return response(['success' => true, 'data' => $patients]);
    }

    public function getPatient(Request $request, User $user)
    {
        return $user;
    }
    public function getDoctors(Request $request)
    {
        $doctors = Doctor::all();
        $doctors->load('user');

        return response(['success' => true, 'data' => $doctors]);
    }

    public function getDoctor(Request $request, User $user)
    {
        return $user;
    }

    public function getAppointments()
    {
        $appointements = Appointment::all();

        return $appointements;
    }

    public function getAppointment(Request $request, Appointment $appointment)
    {
        if (!$appointment) {
            return response(['success' => false, 'message' => 'Appointment not found.']);
        }

        return response(['success' => true, 'data' => $appointment]);
    }
}
