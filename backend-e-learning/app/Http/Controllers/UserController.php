<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allUsers()
    {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'data' => UserResource::collection($users),
        ]);
    }

    public function adminUsers() {
        $users = User::where('level', 'admin')->get();

        return response()->json([
            'status' => 'success',
            'data' => UserResource::collection($users),
        ]);
    }

    public function teacherUsers() {
        $users = User::where('level', 'teacher')->get();

        return response()->json([
            'status' => 'success',
            'data' => UserResource::collection($users),
        ]);
    }

    public function studentUsers() {
        $users = User::where('level', 'student')->get();

        return response()->json([
            'status' => 'success',
            'data' => UserResource::collection($users),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_username' => 'required|alpha:ascii|max:255|unique:users,username',
            'user_name' => 'required|max:255',
            'user_image' => 'image|file|mimes:jpg,jpeg,png|max:256',
            'user_email' => 'required|email:dns|unique:users,email',
            'user_password' => 'required|min:8|max:255|confirmed',
        ]);

        if($request->user_level) {
            $validateData['user_level'] = $request->user_level;
        } else {
            $validateData['user_level'] = 'student';
        }

        if($request->user_paid_status) {
            $validateData['user_paid_status'] = $request->user_paid_status;
        } else {
            $validateData['user_paid_status'] = 0;
        }

        if($request->file('user_image')) {
            $validateData['user_image'] = $request->file('user_image')->store('user/image');
        }

        $validateData['user_password'] = Hash::make($validateData['user_password']);

        User::create([
            'username' => $validateData['user_username'],
            'name' => $validateData['user_name'],
            'image' => ($request->file('user_image')) ? $validateData['user_image'] : null,
            'email' => $validateData['user_email'],
            'password' => $validateData['user_password'],
            'level' => $validateData['user_level'],
            'paid_status' => $validateData['user_paid_status'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'New user has been added!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::firstWhere('username', $user->username);

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());

        $rules = [
            // 'user_username' => 'required|alpha:ascii|max:255|unique:users,username',
            'user_name' => 'required|max:255',
            'user_image' => 'image|file|mimes:jpg,jpeg,png|max:256',
            // 'user_email' => 'required|email:dns|unique:users,email',
            // 'user_password' => 'required|min:8|max:255|confirmed',
            'user_level' => 'required',
            'user_paid_status' => 'required',
        ];

        if($request->user_username != $user->username) {
            $rules['user_username'] = 'required|alpha:ascii|max:255|unique:users,username';
        }

        if($request->user_email != $user->email) {
            $rules['user_email'] = 'required|email:dns|unique:users,email';
        }

        $validateData = $request->validate($rules);

        if($request->file('user_image')) {
            if($request->old_user_image) {
                Storage::delete($request->old_user_image);
            }

            $validateData['user_image'] = $request->file('user_image')->store('user/image');
        }

        // $validateData['user_password'] = Hash::make($validateData['user_password']);

        $updateRules = [
            // 'username' => $validateData['user_username'],
            'name' => $validateData['user_name'],
            // 'image' => ($request->file('user_image')) ? $validateData['user_image'] : null,
            // 'email' => $validateData['user_email'],
            // 'password' => $validateData['user_password'],
            'level' => $validateData['user_level'],
            'paid_status' => $validateData['user_paid_status'],
        ];

        if($request->user_username != $user->username) {
            $updateRules['username'] = $validateData['user_username'];
        }

        if($request->user_email != $user->email) {
            $updateRules['email'] = $validateData['user_email'];
        }

        if($request->file('user_image')) {
            $updateRules['image'] = $validateData['user_image'];
        }

        User::where('username', $user->username)->update($updateRules);

        return response()->json([
            'status' => 'success',
            'message' => 'User has been updated!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::firstWhere('username', $user->username);

        if($user->image) {
            Storage::delete($user->image);
        }

        Comment::where('user_id', $user->id)->delete();

        User::destroy($user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'User has been deleted!'
        ]);
    }

    public function resetPassword(User $user) {
        $newPassword = Str::password(12);

        User::where('username', $user->username)->update([
            'password' => Hash::make($newPassword)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User password has been reset!',
            'newPassword' => $newPassword
        ]);
    }
}
