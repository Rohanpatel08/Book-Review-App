<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('account.profile');
    }
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Profile has been updated');
    }

    public function changePassword()
    {
        return view('auth.changePassword');
    }

    public function storePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8',
        ]);
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                "password" => Hash::make($request->new_password)
            ]);
            Auth::logout();
            return redirect()->route('login')->with('success', 'Password updated successfully');
        } else {
            return redirect()->route('auth.changePassword')->with('error', 'Old password is wrong. Please re-enter');
        }
    }

    public function verifyEmail(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email'
        // ]);

        // $user = User::where('email', $request->email)->first();

        // if (!$user) {
        //     return response()->json(['message' => 'User not found'], 404);
        // }

        // if ($user->hasVerifiedEmail()) {
        //     return response()->json(['message' => 'Email already verified'], 400);
        // }
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('profile');
    }

    public function resendEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }
}
