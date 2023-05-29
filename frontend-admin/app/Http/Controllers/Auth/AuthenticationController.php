<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        if(isset($_COOKIE['my_key'])) {
            return redirect('/admin');
        }

        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function processLogin(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $response = Http::post(env('SERVER_API') . 'login', $validateData);

        if(json_decode($response)->status == 'success') {
            setcookie('my_token', json_decode($response)->bearer_token);
            setcookie('my_key', json_decode($response)->username);

            // return json_decode($response);
            return redirect()->intended('/admin');
        }

        return back()->with('failed', 'Wrong Username or Password!');
    }

    public function logout() {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->get(env('SERVER_API') . 'logout');

        if(json_decode($response)->status == 'success') {
            setcookie('my_token', '', time()-3600);
            setcookie('my_key', '', time()-3600);

            return redirect('/')->with('success', 'Logout Success!');
        }

        return back()->with('failed', 'Logout Failed!');
    }
}
