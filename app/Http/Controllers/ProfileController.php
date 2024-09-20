<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('account.profile');
    }
    public function updateProfile(ProfileUpdateRequest $request)
    {
        try {
            $user = Auth::user();

            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->hasFile('profile')) {

                if ($user->profile && file_exists(public_path('images/' . $user->profile))) {
                    // Remove the old profile image
                    unlink(public_path('images/' . $user->profile));
                }

                $fileWithExt = $request->file('profile')->getClientOriginalExtension();


                $fileName = time() . '.' . $fileWithExt;

                $path = $request->file('profile')->move(public_path('images'), $fileName);

                $data['profile'] = $fileName;
            }
            $user->update($data);
            return redirect()->route('profile')->with('success', 'Profile has been updated');
        } catch (Exception $e) {

            Log::info($e->getMessage());
            return redirect()->route('profile')->with('error', $e->getMessage());
        }
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
