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

    public function create()
    {
        $user = json_decode($this->user);

        $data = [
            "title" => "All Categories",
            "user" => $user->data,
        ];
        
        return view('dashboard.categories.create', $data);
    }

    public function store(Request $request) {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            'category_slug' => $request->category_slug,
            'category_name' => $request->category_name,
        ];
        
        $store = Http::withHeaders($header)->post(env('SERVER_API') . 'categories', $body);

        if(!$store->ok()) {
            return back()
                ->withInput()
                ->withErrors([
                    "category_slug" => (isset(json_decode($store)->errors->category_slug)) ? json_decode($store)->errors->category_slug : null,
                    "category_name" => (isset(json_decode($store)->errors->category_name)) ? json_decode($store)->errors->category_name : null,
                ]);
        }

        return redirect('/admin/categories')->with('success', 'New matery has been added!');
    }

    public function checkSlug(Request $request) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])
        ->get(env('SERVER_API') . 'categories/check-slug/' . $request->category_name);

        return response()->json(['category_slug' => json_decode($response)->category_slug]);
    }
}
