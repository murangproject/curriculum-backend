<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Mail;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $field = $request->validate([
            'email' => 'required|string|email'
        ]);

        $user = User::where('email', $field['email'])->first();
        if(!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }else {
            $token = $user->createToken('resetPasswordToken')->plainTextToken;
            $url = env('FRONTEND_URL') . "/reset-password/$token";

            Mail::to($user->email)->send(new ResetPassword($url));
            return response()->json(['message' => 'Reset password link sent on your email']);
        }
    }
}
