<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __construct()
    {
        if(isset($_COOKIE['my_key'])) {
            $this->user = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
                ])->get(env('SERVER_API') . 'users/' . $_COOKIE['my_key']);
        }
    }
    
    public function index() {
        return view('index');
    }

    public function freeMateries() {
        $response = Http::accept('application/json')->get(env('SERVER_API') . 'posts/free');
        
        $data = [
            "title" => "Materi Gratis",
            "user" => "Guest",
            "materies" => json_decode($response)->data,
        ];

        if(isset($_COOKIE['my_key'])) {
            $user = json_decode($this->user);
    
            $data["user"] = $user->data;
        }
        
        return view('materies.free', $data);
    }

    public function detailMateries(String $parameter) {
        $response = Http::accept('application/json')->get(env('SERVER_API') . 'posts/' . $parameter);
        
        $data = [
            "title" => "Materi Gratis",
            "user" => "Guest",
            "matery" => json_decode($response)->data,
        ];

        if(isset($_COOKIE['my_key'])) {
            $user = json_decode($this->user);
    
            $data["user"] = $user->data;
        }
        
        return view('materies.detail', $data);
    }
}
