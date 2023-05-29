<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Authentication extends Controller
{
    public function register(Request $request) {
        $validateData = $request->validate([
            'username' => 'required|alpha:ascii|max:255|unique:users,username',
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        if($request->level) {
            $validateData['level'] = $request->level;
        } else {
            $validateData['level'] = 'student';
        }

        if($request->paid_status) {
            $validateData['paid_status'] = $request->paid_status;
        } else {
            $validateData['paid_status'] = 0;
        }

        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Register success!'
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::firstWhere('username', $request->username);

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Wrong username or password!',
            ]);
        }

        $token = $user->createToken('user_token_' . $user->username)->plainTextToken;

        User::where('id', $user->id)->update([
            'api_token' => $token
        ]);

        return response()->json([
            'status' => 'success',
            'username' => $user->username,
            'bearer_token' => $token,
        ]);
    }

    public function logout(Request $request) {

        User::where('id', Auth::user()->id)->update([
            'api_token' => null
        ]);

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout success!',
        ]);
    }
}
