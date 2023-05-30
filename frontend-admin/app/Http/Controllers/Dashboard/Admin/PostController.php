<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
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

        $response = Http::accept('application/json')->get(env('SERVER_API') . 'posts');

        $data = [
            "title" => "All Materies",
            "user" => $user->data,
            "materies" => json_decode($response)->data,
        ];
        
        return view('dashboard.materies.all', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = json_decode($this->user);

        $categories = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->get(env('SERVER_API') . 'categories');

        $data = [
            "title" => "Add Materies",
            "user" => $user->data,
            "categories" => json_decode($categories)->data,
        ];
        
        return view('dashboard.materies.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            'post_slug' => $request->post_slug,
            'post_title' => $request->post_title,
            'post_category' => $request->post_category,
            'post_content' => $request->post_content,
            'post_status' => $request->post_status,
            'post_publish' => $request->post_publish,
        ];

        if($request->file('post_image')) {
            $image = fopen($request->file('post_image'), 'r');
            
            $store = Http::withHeaders($header)
            ->attach(
                'post_image', $image
            )
            ->post(env('SERVER_API') . 'posts', $body);
        } else {
            $store = Http::withHeaders($header)->post(env('SERVER_API') . 'posts', $body);
        }

        if(!$store->ok()) {
            return back()
                ->withInput()
                ->withErrors([
                    "post_slug" => (isset(json_decode($store)->errors->post_slug)) ? json_decode($store)->errors->post_slug : null,
                    "post_title" => (isset(json_decode($store)->errors->post_title)) ? json_decode($store)->errors->post_title : null,
                    "post_category" => (isset(json_decode($store)->errors->post_category)) ? json_decode($store)->errors->post_category : null,
                    "post_image" => (isset(json_decode($store)->errors->post_image)) ? json_decode($store)->errors->post_image : null,
                    "post_content" => (isset(json_decode($store)->errors->post_content)) ? json_decode($store)->errors->post_content : null,
                    "post_status" => (isset(json_decode($store)->errors->post_status)) ? json_decode($store)->errors->post_status : null,
                    "post_publish" => (isset(json_decode($store)->errors->post_publish)) ? json_decode($store)->errors->post_publish : null,
                ]);
        }

        return redirect('/admin/materies')->with('success', 'New matery has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $post_slug)
    {
        $user = json_decode($this->user);

        $response = Http::accept('application/json')->get(env('SERVER_API') . 'posts/' . $post_slug);

        $data = [
            "title" => "Detail Matery",
            "user" => $user->data,
            "matery" => json_decode($response)->data,
        ];
        
        return view('dashboard.materies.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $parameter)
    {
        $user = json_decode($this->user);

        $categories = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->get(env('SERVER_API') . 'categories');

        $matery = Http::accept('application/json')->get(env('SERVER_API') . 'posts/' . $parameter);

        $data = [
            "title" => "Edit Matery",
            "user" => $user->data,
            "categories" => json_decode($categories)->data,
            "matery" => json_decode($matery)->data,
        ];
        
        return view('dashboard.materies.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $parameter)
    {
        $header = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ];

        $body = [
            'post_slug' => $request->post_slug,
            'post_title' => $request->post_title,
            'post_category' => $request->post_category,
            'post_content' => $request->post_content,
            'post_status' => $request->post_status,
            'post_publish' => $request->post_publish,
            'old_post_status' => $request->old_post_status,
        ];

        if($request->file('post_image')) {
            $body['old_post_image'] = $request->old_post_image;
            $image = fopen($request->file('post_image'), 'r');
            
            $update = Http::withHeaders($header)
            ->attach(
                'post_image', $image
            )
            ->put(env('SERVER_API') . 'posts/' . $parameter, $body);
        } else {
            $update = Http::withHeaders($header)->put(env('SERVER_API') . 'posts/' . $parameter, $body);
        }

        if(!$update->ok()) {
            return back()
                ->withInput()
                ->withErrors([
                    "post_slug" => (isset(json_decode($update)->errors->post_slug)) ? json_decode($update)->errors->post_slug : null,
                    "post_title" => (isset(json_decode($update)->errors->post_title)) ? json_decode($update)->errors->post_title : null,
                    "post_category" => (isset(json_decode($update)->errors->post_category)) ? json_decode($update)->errors->post_category : null,
                    "post_image" => (isset(json_decode($update)->errors->post_image)) ? json_decode($update)->errors->post_image : null,
                    "post_content" => (isset(json_decode($update)->errors->post_content)) ? json_decode($update)->errors->post_content : null,
                    "post_status" => (isset(json_decode($update)->errors->post_status)) ? json_decode($update)->errors->post_status : null,
                    "post_publish" => (isset(json_decode($update)->errors->post_publish)) ? json_decode($update)->errors->post_publish : null,
                ]);
        }

        return redirect('/admin/materies')->with('success', 'Matery has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $parameter)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
        ])->delete(env('SERVER_API') . 'posts/' . $parameter);

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
        ->get(env('SERVER_API') . 'posts/check-slug/' . $request->post_title);

        return response()->json(['post_slug' => json_decode($response)->post_slug]);
    }
}
