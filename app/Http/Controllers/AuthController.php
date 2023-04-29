<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $fullname = $user->first_name . ' ' . $user->last_name;

        Activity::create([
            'user_id' => $user->id,
            'type' => 'login',
            'description' => $fullname . ' logged in'
        ]);

        $initialize = $fields['password'] == env('INITIAL_USER_PASSWORD');

        $response = [];

        if($initialize) {
            $response = [
                'user' => $user,
                'token' => $token,
                'initialize' => $initialize
            ];
        } else {
            $response = [
                'user' => $user,
                'token' => $token
            ];
        }

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        Activity::create([
            'user_id' => $request->user()->id,
            'type' => 'logout',
            'description' => $request->user()->first_name . ' ' . $request->user()->last_name . ' logged out'
        ]);

        return [
            'message' => 'Logged out'
        ];
    }

    public function checkRole(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        return response()->json(['role' => $role], 200);
    }
}
