<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
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

        $response = Http::accept('application/json')->get(env('SERVER_API') . 'categories');

        $data = [
            "title" => "All Categories",
            "user" => $user->data,
            "categories" => json_decode($response)->data,
        ];
        
        return view('dashboard.categories.index', $data);
    }
}
