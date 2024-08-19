<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        return response(["success" => true, "message" => "Updated profile details."]);
    }

    public function getProfile(Request $request)
    {
        return $request->user();
    }

    public function deleteAccount(Request $request)
    {
        return 'Delete account';
    }
}
