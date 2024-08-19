<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Added this line


class AdminController extends Controller
{

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

        // return response(['success' => true, 'message' => 'Admin logged out successfully.']);
        return "logged out";
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

        return response(['success' => true, "message" => "Patient deleted."]);
    }

    public function getPatients()
    {
        $patients = Patient::all();
        $patients->load('user');

        return response(['success' => true, 'data' => $patients]);
    }

    public function getPatient()
    {
        return "A patient";
    }
    public function getDoctors(Request $request)
    {

        $doctors = Doctor::all();
        $doctors->load('user');

        return response(['success' => true, 'data' => $doctors]);
    }

    public function getDoctor()
    {
        return "A doctor";
    }
}
