<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Auth/Register');
    }

    public function register(StorePatientRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($validatedData['password']),
            'userType' => 'patient',
        ]);

        Patient::create([
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        // Check if user exists and the password matches
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function loginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function logout(Request $request)
    {
        // Log the user out and regenerate the session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page or home
        return redirect('/auth/login');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $patient = $user->patient;

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:100',
            'dateOfBirth' => 'nullable|date',
            // 'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->fill([
            'name' => $validatedData['name'] ?? $user->name,
            'dateOfBirth' => isset($validatedData['dateOfBirth'])
                ? Carbon::parse($validatedData['dateOfBirth'])
                : $user->dateOfBirth,
        ]);

        if (isset($validatedData['address'])) {
            $patient->address = $validatedData['address'];
            $patient->save();
        }

        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $avatarPath = $avatar->storeAs(
        //         'assets/avatars',
        //         $avatar->hashName(),
        //         'public'
        //     );

        //     if ($user->avatar) {
        //         Storage::disk('public')->delete($user->avatar);
        //     }

        //     $user->avatar = $avatarPath;
        // }
        $avatarName = '';

        if ($request->hasFile('avatar')) {
            return Route::redirect('/');

            // $request->validate([
            //     'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            // ]);

            // $user->avatar = 'newImage.jpg';

            // delete old profile from public
            // if ($user->avatar) {
            //     $currentProfileName = public_path('assets/profile_images/' . basename($user->avatar));
            //     if (File::exists($currentProfileName)) {
            //         File::delete($currentProfileName);
            //     }
            // }

            // $uploadedAvatar = $request->file('avatar');
            // $newProfileName = time() . '.' . $uploadedAvatar->getClientOriginalExtension();
            // $uploadedAvatar->move(public_path('/assets/profile_images/'), $newProfileName);

            // $user->avatar = $request->getSchemeAndHttpHost() . '/assets/profile_images/' . $newProfileName;
        }

        $user->save();

        if ($user->save()) {
            return back()->with('success', 'Profile updated successfully.');
        } else {
            return back()->withErrors($user->errors())->withInput();
        }
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        $user->load('patient');

        $appointments = Appointment::with(['doctor.user'])
            ->where('patient_id', $this->getPatientId($request))
            ->get();

        return Inertia::render(
            'PatientProfile',
            ['user' => $user, 'appointments' => $appointments]
        );
    }

    private function getPatientId(Request $request)
    {
        return $request->user()->patient()->first()->id;
    }
}
