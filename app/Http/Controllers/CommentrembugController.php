<?php

namespace App\Http\Controllers;

use App\Models\commentrembug;
use App\Models\Meeting;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Http\Request;

class CommentrembugController extends Controller
{

    public function index($id)
    {
        $post = Meeting::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        return response([
            'comments' => $post->comments()->with('users:id,name,image_user,username')->get()
        ], 200);
    }


    // create a comment
    public function store(Request $request, $id)
    {
        $post = Meeting::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        //validate fields
        $attrs = $request->validate([
            'comment' => 'required|string',
            'commentdate' => 'required'
        ]);

        $data = commentrembug::create([
            'comment' => $attrs['comment'],
            'commentdate' => $attrs['commentdate'],
            'id_post' => $id,
            'id_user' => auth()->user()->id
        ]);

        return response([
            'comments' => $data
        ], 200);
    }

    // update a comment
    public function update(Request $request, $id)
    {
        $comment = commentrembug::find($id);

        if(!$comment)
        {
            return response([
                'message' => 'Comment not found.'
            ], 403);
        }

        if($comment->id_user != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        //validate fields
        $attrs = $request->validate([
            'comment' => 'required|string'
        ]);

        $comment->update([
            'comment' => $attrs['comment']
        ]);

        return response([
            'message' => 'Comment updated.'
        ], 200);
    }

    // delete a comment
    public function destroy($id)
    {
        $comment = commentrembug::find($id);

        if(!$comment)
        {
            return response([
                'message' => 'Comment not found.'
            ], 403);
        }

        if($comment->id_user != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        $comment->delete();

        return response([
            'message' => 'Comment deleted.'
        ], 200);
    }
}
