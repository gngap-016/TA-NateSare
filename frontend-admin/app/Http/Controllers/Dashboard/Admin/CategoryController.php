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

    public function edit(String $parameter)
    {
        $user = json_decode($this->user);

        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];
        
        $response = Http::withHeaders($header)->get(env('SERVER_API') . 'categories/' . $parameter);

        $data = [
            "title" => "Edit Categories",
            "user" => $user->data,
            "category" => json_decode($response)->data
        ];
        
        return view('dashboard.categories.edit', $data);
    }

    public function update(Request $request, String $parameter) {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            'category_slug' => $request->category_slug,
            'category_name' => $request->category_name,
        ];
        
        $store = Http::withHeaders($header)->put(env('SERVER_API') . 'categories/' . $parameter, $body);

        if(!$store->ok()) {
            return back()
                ->withInput()
                ->withErrors([
                    "category_slug" => (isset(json_decode($store)->errors->category_slug)) ? json_decode($store)->errors->category_slug : null,
                    "category_name" => (isset(json_decode($store)->errors->category_name)) ? json_decode($store)->errors->category_name : null,
                ]);
        }

        return redirect('/admin/categories')->with('success', 'Matery has been updated!');
    }

    public function destroy(String $parameter) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->delete(env('SERVER_API') . 'categories/' . $parameter);

        if(!$response->ok()) {
            return back()->with('failed', 'Delete matery failed!');
        }

        return response([
            "status" => "success"
        ], http_response_code());
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
