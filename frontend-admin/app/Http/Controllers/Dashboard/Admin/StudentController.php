<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StudentController extends Controller
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
        ])->get(env('SERVER_API') . 'users/student');

        $data = [
            "title" => "Students",
            "user" => $user->data,
            "users" => json_decode($response)->data,
        ];
        
        return view('dashboard.students.index', $data);
    }
}
