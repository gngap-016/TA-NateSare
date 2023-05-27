<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Path\To\DOMDocument;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{
    public function allPosts()
    {
        $posts = Post::all();

        return response()->json([
            'status' => 'success',
            'data' => PostResource::collection($posts),
        ]);
    }

    public function freePosts()
    {
        $posts = Post::where('status', 'free')->get();

        return response()->json([
            'status' => 'success',
            'data' => PostResource::collection($posts),
        ]);
    }

    public function paidPosts()
    {
        $posts = Post::where('status', 'paid')->get();

        return response()->json([
            'status' => 'success',
            'data' => PostResource::collection($posts),
        ]);
    }

    public function publishedPosts()
    {
        $posts = Post::where('publish', 1)->get();

        return response()->json([
            'status' => 'success',
            'data' => PostResource::collection($posts),
        ]);
    }

    
    public function draftedPosts()
    {
        $posts = Post::where('publish', 0)->get();

        return response()->json([
            'status' => 'success',
            'data' => PostResource::collection($posts),
        ]);
    }

    public function show(Post $post)
    {
        $post = Post::firstWhere('slug', $post->slug);

        return response()->json([
            'status' => 'success',
            'data' => new PostResource($post),
        ]);
    }

    public function store(Request $request)
    {
        // ----------------------------------------------------------
        // VALIDATION RULES
        // ----------------------------------------------------------
        $validateData = $request->validate([
            'post_slug' => 'required|max:255|unique:posts,slug',
            // 'post_excerpt' => 'required',
            'post_title' => 'required',
            'post_category' => 'required',
            'post_image' => 'nullable|image|file|mimes:jpg,jpeg,png|max:512',
            'post_content' => 'required',
            'post_status' => 'required',
            'post_publish' => 'required',
        ]);

        $validateData['post_author'] = Auth::user()->id;

        if($request->post_publish == 1) {
            $validateData['post_published_at'] = \Carbon\Carbon::now()->toDateTimeString();
        }

        if($request->file('post_image')) {
            $validateData['post_image'] = $request->file('post_image')->store('post/cover');
        }

        $storageImageContent = "post/content/".$request->post_slug;
        Storage::makeDirectory($storageImageContent);

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($request->post_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();
        $contentImages = $dom->getElementsByTagName('img');
        foreach ($contentImages as $contentImage) {
            $src = $contentImage->getAttribute('src');
            if(preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                $fileNameContent = uniqid();
                $fileNameContentRandom = substr(md5($fileNameContent), 6, 6).'_'.time();
                $filePath = ("storage/$storageImageContent/$fileNameContentRandom.$mimetype");
                $image = Image::make($src)
                            ->encode($mimetype, 100)
                            ->save(public_path($filePath));
                $new_src = asset($filePath);
                $contentImage->removeAttribute('src');
                $contentImage->setAttribute('src', $new_src);
                $contentImage->setAttribute('class', 'img-responsive');
            }
        }

        $validateData['post_excerpt'] = Str::limit(strip_tags($request->post_content), 160);
        $validateData['post_content'] = $dom->saveHTML();

        // ----------------------------------------------------------
        // CREATE POST
        // ----------------------------------------------------------
        Post::create([
            'slug' => $validateData['post_slug'],
            'title' => $validateData['post_title'],
            'category_id' => $validateData['post_category'],
            'image' => ($request->file('post_image')) ? $validateData['post_image'] : null,
            'excerpt' => $validateData['post_excerpt'],
            'body' => $validateData['post_content'],
            'status' => $validateData['post_status'],
            'author_id' => $validateData['post_author'],
            'publish' => $validateData['post_publish'],
            'published_at' => ($request->post_publish == 1) ? $validateData['post_published_at'] : null,
        ]);

        // ----------------------------------------------------------
        // RESPONSE
        // ----------------------------------------------------------
        return response()->json([
            'status' => 'success',
            'data' => "New matery has been added!",
        ]);
    }

    public function update(Request $request, Post $post) {

        // ----------------------------------------------------------
        // VALIDATION RULES
        // ----------------------------------------------------------
        $rules = [
            // 'post_slug' => 'required|max:255|unique:posts,slug',
            // 'post_excerpt' => 'required',
            'post_title' => 'required',
            'post_category' => 'required',
            'post_image' => 'nullable|image|file|mimes:jpg,jpeg,png|max:512',
            'post_content' => 'required',
            'post_status' => 'required',
            'post_publish' => 'required',
        ];

        if($request->post_slug != $post->slug) {
            $rules['post_slug'] = 'required|max:255|unique:posts,slug';
        }

        $validateData = $request->validate($rules);

        if($request->file('post_image')) {
            if($request->old_post_image) {
                Storage::delete($request->old_post_image);
            }
            $validateData['post_image'] = $request->file('post_image')->store('post/cover');
        }

        $storageImageContent = "post/content/".$request->post_slug;
        Storage::deleteDirectory($storageImageContent);
        Storage::makeDirectory($storageImageContent);

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($request->post_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();
        $contentImages = $dom->getElementsByTagName('img');
        foreach ($contentImages as $contentImage) {
            $src = $contentImage->getAttribute('src');
            if(preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                $fileNameContent = uniqid();
                $fileNameContentRandom = substr(md5($fileNameContent), 6, 6).'_'.time();
                $filePath = ("storage/$storageImageContent/$fileNameContentRandom.$mimetype");
                $image = Image::make($src)
                            ->encode($mimetype, 100)
                            ->save(public_path($filePath));
                $new_src = asset($filePath);
                $contentImage->removeAttribute('src');
                $contentImage->setAttribute('src', $new_src);
                $contentImage->setAttribute('class', 'img-responsive');
            }
        }

        $validateData['post_author'] = Auth::user()->id;

        $validateData['post_excerpt'] = Str::limit(strip_tags($request->post_content), 160);
        $validateData['post_content'] = $dom->saveHTML();

        if($request->post_publish == 1 && $request->old_post_publish == 0) {
            $validateData['post_published_at'] = \Carbon\Carbon::now()->toDateTimeString();
        }

        // ----------------------------------------------------------
        // UPDATE RULES
        // ----------------------------------------------------------
        $updateRules = [
            'title' => $validateData['post_title'],
            'category_id' => $validateData['post_category'],
            'excerpt' => $validateData['post_excerpt'],
            'body' => $validateData['post_content'],
            'status' => $validateData['post_status'],
            'author_id' => $validateData['post_author'],
            'publish' => $validateData['post_publish'],
        ];

        if($request->post_slug != $post->slug) {
            $updateRules['slug'] = $validateData['post_slug'];
        }

        if($request->file('post_image')) {
            $updateRules['image'] = $validateData['post_image'];
        }

        if($request->post_publish == 1 && $request->old_post_publish == 0) {
            $updateRules['published_at'] = $validateData['post_published_at'];
        }

        // ----------------------------------------------------------
        // UPDATE POST
        // ----------------------------------------------------------
        Post::where('slug', $post->slug)->update($updateRules);

        // ----------------------------------------------------------
        // RESPONSE
        // ----------------------------------------------------------
        return response()->json([
            'status' => 'success',
            'data' => "Matery has been updated!",
        ]);
    }

    public function destroy(Post $post) {
        // ----------------------------------------------------------
        // DELETE POST IMAGE IF EXISTS
        // ----------------------------------------------------------
        if($post->image) {
            Storage::delete($post->image);
        }

        // ----------------------------------------------------------
        // DELETE FOLDER POST
        // ----------------------------------------------------------
        $storageImageContent = "post/content/" . $post->slug;
        Storage::deleteDirectory($storageImageContent);

        // ----------------------------------------------------------
        // DELETE POST
        // ----------------------------------------------------------
        Post::destroy($post->id);

        // ----------------------------------------------------------
        // RESPONSE
        // ----------------------------------------------------------
        return response()->json([
            'status' => 'success',
            'data' => "Matery has been deleted!",
        ]);
    }


    public function checkSlug(Request $request) {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->post_title);

        return response()->json(['post_slug' => $slug]);
    }
}
