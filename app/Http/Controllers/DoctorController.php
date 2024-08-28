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

class DoctorController extends Controller
{
    public function register(StoreDoctorRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            "userType" => 'doctor'
        ]);

        Doctor::create([
            'user_id' => $user->id,
        ]);

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
        // $user->load('doctor');


        return response([
            "success" => true,
            "token" => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['success' => true, 'message' => 'Doctor logged out successfully.']);
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
        // if ($request->email || $request->password) {
        //     return response(['success' => false, 'message' => 'Cannot update phone or password here.']);
        // }

        $user = User::findOrFail($request->user()->id);
        // $user->load('doctor');

        // if ($request->dob) {
        //     $user->dateOfBirth = Carbon::parse($request->dob);
        // }

        // $avatarName = '';
        // if ($request->hasFile('image')) {
        //     $validatedAvatar = $request->validate(['image' => 'image|mimes:jpg,png,jpeg|max:2048']);
        //     $avatar = $request->file('image');
        //     $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
        //     $avatar->move(public_path('/assets/avatars/'), $avatarName);

        //     $avatarName = $request->getSchemeAndHttpHost() . '/assets/avatars/' . $avatarName;
        // }

        // $user->avatar = $avatarName;
        // $user->save();

        // $doctor = Doctor::findOrFail($this->getDoctorId());
        // $doctor->update($request->only(['bio', 'specialization', 'yearsOfExperience']));
        // $doctor->save();

        return response([
            'message' => 'Profile updated successfully.',
            'user' => $user,
            // 'doctor' => $doctor
        ]);
    }

    private function getDoctorId()
    {
        return auth()->user()->doctor()->first()->id;
    }
}
