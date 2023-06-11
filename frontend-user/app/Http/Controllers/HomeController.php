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
        $data = [
            "title" => "Beranda",
            "user" => "Guest",
        ];

        if(isset($_COOKIE['my_key'])) {
            $user = json_decode($this->user);
    
            $data["user"] = $user->data;
        }

        return view('index', $data);
    }

    public function freeMateries() {
        $materies = Http::accept('application/json')->get(env('SERVER_API') . 'posts/free');
        $categories = Http::accept('application/json')->get(env('SERVER_API') . 'categories');
        
        $data = [
            "title" => "Materi Gratis",
            "user" => "Guest",
            "materies" => json_decode($materies)->data,
            "categories" => json_decode($categories)->data,
        ];

        if(isset($_COOKIE['my_key'])) {
            $user = json_decode($this->user);
    
            $data["user"] = $user->data;
        }
        
        return view('materies.materies', $data);
    }

    public function paidMateries() {
        $materies = Http::accept('application/json')->get(env('SERVER_API') . 'posts/paid');
        $categories = Http::accept('application/json')->get(env('SERVER_API') . 'categories');
        
        $data = [
            "title" => "Materi Berbayar",
            "user" => "Guest",
            "materies" => json_decode($materies)->data,
            "categories" => json_decode($categories)->data,
        ];

        if(isset($_COOKIE['my_key'])) {
            $user = json_decode($this->user);
    
            $data["user"] = $user->data;
        }
        
        return view('materies.materies', $data);
    }

    public function detailMateries(String $parameter) {
        $materies = Http::accept('application/json')->get(env('SERVER_API') . 'posts/' . $parameter);
        $categories = Http::accept('application/json')->get(env('SERVER_API') . 'categories');
        
        $data = [
            "title" => json_decode($materies)->data->post_title,
            "user" => "Guest",
            "matery" => json_decode($materies)->data,
            "categories" => json_decode($categories)->data,
        ];

        if(isset($_COOKIE['my_key'])) {
            $user = json_decode($this->user);
    
            $data["user"] = $user->data;
        }
        
        return view('materies.detail', $data);
    }

    public function commentMateries(Request $request) {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            'post_slug' => $request->post_slug,
            'comment_content' => $request->comment_content,
        ];
        
        $store = Http::withHeaders($header)->post(env('SERVER_API') . 'comment', $body);

        return back();
    }
}
