<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdministratorController extends Controller
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

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->get(env('SERVER_API') . 'users/admin');

        $data = [
            "title" => "Administrators",
            "user" => $user->data,
            "administrators" => json_decode($response)->data,
        ];
        
        return view('dashboard.administrators.index', $data);
    }

    public function create() {
        $user = json_decode($this->user);

        $data = [
            "title" => "Administrators",
            "user" => $user->data,
        ];
        
        return view('dashboard.administrators.create', $data);
    }

    public function store(Request $request)
    {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            'user_username' => $request->user_username,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_password' => $request->user_password,
            'user_password_confirmation' => $request->user_password_confirmation,
            'user_level' => 'admin',
        ];

        if($request->file('user_image')) {
            $image = fopen($request->file('user_image'), 'r');
            
            $store = Http::withHeaders($header)
            ->attach(
                'user_image', $image
            )
            ->post(env('SERVER_API') . 'users', $body);
        } else {
            $store = Http::withHeaders($header)->post(env('SERVER_API') . 'users', $body);
        }

        if(!$store->ok()) {
            return back()
                ->withInput()
                ->withErrors([
                    "user_username" => (isset(json_decode($store)->errors->user_username)) ? json_decode($store)->errors->user_username : null,
                    "user_name" => (isset(json_decode($store)->errors->user_name)) ? json_decode($store)->errors->user_name : null,
                    "user_email" => (isset(json_decode($store)->errors->user_email)) ? json_decode($store)->errors->user_email : null,
                    "user_image" => (isset(json_decode($store)->errors->user_image)) ? json_decode($store)->errors->user_image : null,
                    "user_password" => (isset(json_decode($store)->errors->user_password)) ? json_decode($store)->errors->user_password : null,
                ]);
        }

        return redirect('/admin/users/administrators')->with('success', 'New administrator has been added!');
    }

    public function edit(String $parameter)
    {
        $user = json_decode($this->user);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->get(env('SERVER_API') . 'users/' . $parameter);

        $data = [
            "title" => "Administrators",
            "user" => $user->data,
            "user" => json_decode($response)->data,
        ];
        
        return view('dashboard.administrators.edit', $data);
    }

    public function update(Request $request, String $parameter)
    {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            '_method' => 'PUT',
            'user_username' => $request->user_username,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_level' => 'admin',
            'user_paid_status' => 0,
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

        return redirect('/admin/users/administrators')->with('success', 'administrator has been updated!');
    }

    public function destroy(String $parameter) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->delete(env('SERVER_API') . 'users/' . $parameter);

        if(!$response->ok()) {
            return back()->with('failed', 'Delete user failed!');
        }

        return response([
            "status" => "success"
        ], http_response_code());
    }

    public function resetPassword(String $parameter) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->put(env('SERVER_API') . 'users/password-reset/' . $parameter);

        if(!$response->ok()) {
            return back()->with('failed', 'Reset password user failed!');
        }

        return response([
            "status" => "success",
            "newPassword" => json_decode($response)->newPassword
        ], http_response_code());
    }
}
