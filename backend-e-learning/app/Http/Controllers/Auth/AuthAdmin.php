<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthAdmin extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::firstWhere('username', $request->username);

        if(!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'failed' => ['Wrong Username or Password!'],
            ]);
        }

        $token = $user->createToken('user_token_' . $user->username)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'bearer_token' => $token,
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }
}
