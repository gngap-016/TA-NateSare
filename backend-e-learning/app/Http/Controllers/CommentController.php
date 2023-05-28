<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // ----------------------------------------------------------
    // CREATE COMMENT
    // ----------------------------------------------------------
    public function store(Request $request) {
        $validateData = $request->validate([
            'post_slug' => 'required|exists:posts,slug',
            'comment_content' => 'required',
        ]);
        
        $validateData['user_id'] = Auth::user()->id;

        Comment::create([
            'user_id' => $validateData['user_id'],
            'post_slug' => $validateData['post_slug'],
            'body' => $validateData['comment_content'],
        ]);

        // RESPONSE
        return response()->json([
            'status' => 'success',
            'data' => "New comment has been added!",
        ]);
    }

    public function update(Request $request, Comment $comment) {
        if($comment->user_id != Auth::user()->id) {
            return response()->json([
                'status' => 'failed',
                'data' => "You're not able to update this comment!",
            ]);
        }

        $validateData = $request->validate([
            'post_slug' => 'required|exists:posts,slug',
            'comment_content' => 'required',
        ]);

        Comment::where('id', $comment->id)->update([
            'post_slug' => $validateData['post_slug'],
            'body' => $validateData['comment_content'],
        ]);

        // RESPONSE
        return response()->json([
            'status' => 'success',
            'data' => "Your comment has been updated!",
        ]);
    }

    public function destroy(Comment $comment) {
        if($comment->user_id != Auth::user()->id) {
            return response()->json([
                'status' => 'failed',
                'data' => "You're not able to delete this comment!",
            ]);
        }

        Comment::where('id', $comment->id)->delete();

        // RESPONSE
        return response()->json([
            'status' => 'success',
            'data' => "Your comment has been deleted!",
        ]);
    }
}
