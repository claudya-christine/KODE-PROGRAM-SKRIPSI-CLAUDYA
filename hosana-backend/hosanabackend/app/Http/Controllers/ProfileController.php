<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        // Simpan file
        $imageName = $user->id . '_' . time() . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path('uploads/profile'), $imageName);

        // Update database
        $user->profile_image = 'uploads/profile/' . $imageName;
        $user->save();

        return response()->json([
            'message' => 'Profile image updated successfully!',
            'profile_image' => $user->profile_image
        ]);
    }
}
