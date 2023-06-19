<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function register() {
        return view('auth.register', [
            "title" => "Registrasi"
        ]);
    }

    public function login()
    {
        if(isset($_COOKIE['my_key'])) {
            return redirect('/dashboard');
        }

        return view('auth.login', [
            'title' => 'Masuk',
        ]);
    }

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
            return redirect()->intended('/');
        }

        return back()->with('failed', 'Username atau password salah!');
    }

    public function processRegister(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|alpha:ascii|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:255|confirmed',
            'password_confirmation' => 'required',
        ]);

        $response = Http::accept('application/json')->post(env('SERVER_API') . 'register', $validateData);

        if($response->ok()) {
            // return json_decode($response);
            if(json_decode($response)->status == 'success') {
                return back()->with('success', 'Akun anda berhasil dibuat, silahkan login!');
            }
            
            return back()->with('failed', 'Akun anda gagal dibuat!');
        }

        return back()->with('failed', 'Akun anda gagal dibuat!');
    }

    public function logout() {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->get(env('SERVER_API') . 'logout');

        if(json_decode($response)->status == 'success') {
            setcookie('my_token', '', time()-3600);
            setcookie('my_key', '', time()-3600);

            return redirect('/masuk')->with('success', 'Proses keluar Anda berhasil!');
        }

        return redirect('/masuk')->with('failed', 'Logout gagal!');
    }
}
