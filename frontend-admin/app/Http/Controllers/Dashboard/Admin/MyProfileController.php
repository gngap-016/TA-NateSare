<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MyProfileController extends Controller
{
    public function __construct()
    {
        $this->user = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
            ])->get(env('SERVER_API') . 'users/' . $_COOKIE['my_key']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = json_decode($this->user);

        $data = [
            "title" => $user->data->user_name,
            "user" => $user->data,
        ];
        
        return view('dashboard.my_profile.index', $data);
    }

    public function edit() {
        $user = json_decode($this->user);

        $data = [
            "title" => $user->data->user_name,
            "user" => $user->data,
        ];
        
        return view('dashboard.my_profile.edit', $data);
    }

    public function update(Request $request, String $parameter) {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            '_method' => 'PUT',
            'user_username' => $request->user_username,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_level' => $request->user_level,
            'user_paid_status' => $request->user_paid_status,
        ];

        
        if($request->file('user_image')) {
            $body['old_user_image'] = $request->old_user_image;
            $image = fopen($request->file('user_image'), 'r');

            $store = Http::withHeaders($header)
                ->attach(
                    'user_image', $image
                )
                ->post(env('SERVER_API') . 'users/' . $parameter, $body);
            } else {
                $store = Http::withHeaders($header)->post(env('SERVER_API') . 'users/' . $parameter, $body);
            }

            if(!$store->ok()) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "user_username" => (isset(json_decode($store)->errors->user_username)) ? json_decode($store)->errors->user_username : null,
                        "user_name" => (isset(json_decode($store)->errors->user_name)) ? json_decode($store)->errors->user_name : null,
                        "user_email" => (isset(json_decode($store)->errors->user_email)) ? json_decode($store)->errors->user_email : null,
                        "user_image" => (isset(json_decode($store)->errors->user_image)) ? json_decode($store)->errors->user_image : null,
                    ]);
            }

            return redirect('/admin/my-profile')->with('success', 'Your profile has been updated!');
    }

    public function changePassword() {
        $user = json_decode($this->user);

        $data = [
            "title" => $user->data->user_name,
            "user" => $user->data,
        ];
        
        return view('dashboard.my_profile.change_password', $data);
    }

    public function updatePassword(Request $request, String $parameter) {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            '_method' => 'PUT',
            'user_password' => $request->user_password,
            'user_password_confirmation' => $request->user_password_confirmation,
        ];

        $store = Http::withHeaders($header)->post(env('SERVER_API') . 'users/password-change/' . $parameter, $body);

        if(!$store->ok()) {
            return back()
                ->withInput()
                ->withErrors([
                    "user_password" => (isset(json_decode($store)->errors->user_password)) ? json_decode($store)->errors->user_password : null,
                ]);
        }

        return redirect('/admin/my-profile')->with('success', 'Your password has been updated!');
    }
}
