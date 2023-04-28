<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
    }

    public function active() {
        $users = User::all();
        $activeUsers = $users->filter(function ($user) {
            return Hash::check(env('INITIAL_USER_PASSWORD'), $user->password) == false && $user->deleted == false;
        })->values();
        return response()->json(['users'=> $activeUsers], 200);
    }

    public function invited() {
        $users = User::all();
        $invitedUsers = $users->filter(function ($user) {
            return Hash::check(env('INITIAL_USER_PASSWORD'), $user->password) == true && $user->deleted == false;
        })->values();
        return response()->json(['users'=> $invitedUsers], 200);
    }

    public function init(Request $request) {
        $user = $request->user();

        $fields = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email,'.$user->id,
            'password' => 'required|string|confirmed|min:8',
        ]);

        $updated = DB::table('users')->where('id', $user->id)->update([
            'first_name' => $fields['first_name'],
            'middle_name' => $fields['middle_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        if($updated) {
            return response([
                'message' => 'User successfully updated',
            ], 200);
        } else {
            return response([
                'message' => 'User was not updated'
            ], 500);
        }
    }

    public function current(Request $request) {
        return $request->user();
    }

    public function me(Request $request) {
        $user = $request->user();
        return response()->json(['user' => $user], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|unique:users,email',
            'role_name' => 'required|string',
            'role_type' => 'required|in:admin,committee_chair,committee_member,stakeholder',
        ]);

        $created = User::create([
            'email' => $fields['email'],
            'role_name' => $fields['role_name'],
            'role_type' => $fields['role_type'],
            'password' => Hash::make(env('INITIAL_USER_PASSWORD')),
        ]);

        if($created) {
            return response()->json([
                'message' => 'User successfully created',
            ], 201);
        } else {
            return response()->json([
                'message' => 'User was not created'
            ], 500);
        }
    }

    public function show(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $userToUpdate = User::findOrfail($id);

        if($user->id == $userToUpdate->id) {
            return response()->json([
                'message' => 'You cannot update yourself'
            ], 403);
        }

        if($user->role_type != 'admin') {
            return response()->json([
                'message' => 'You do not have permission to update this user'
            ], 403);
        }

        $fields = $request->validate(
            [
                'first_name' => 'string',
                'middle_name' => 'string',
                'last_name' => 'string',
                'email' => 'string|unique:users,email,'.$id,
                'address' => 'string',
                'description' => 'string',
                'role_name' => 'string',
                'role_type' => 'in:admin,committee_chair,committee_member,stakeholder',
                'deleted' => 'boolean',
            ]
        );

        $updated = $userToUpdate->update($fields);

        if($updated) {
            return response()->json([
                'message' => 'User successfully updated',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User was not updated'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $user = auth()->user();
        $userToDelete = User::findOrfail($id);
        if($user->id == $userToDelete->id) {
            return response()->json([
                'message' => 'You cannot delete yourself'
            ], 403);
        }

        $deleted = $userToDelete->update([
            'deleted' => true,
        ]);

        if($deleted) {
            return response()->json([
                'message' => 'User successfully deleted',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User was not deleted'
            ], 500);
        }
    }
}
