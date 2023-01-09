<?php

namespace App\Http\Controllers;

use App\Models\likesrembug;
use App\Models\Meeting;
use Illuminate\Http\Request;

class LikesrembugController extends Controller
{
    public function likeOrUnlike($id)
    {
        $post = Meeting::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        $like = $post->likes()->where('id_user', auth()->user()->id)->first();

        // if not liked then like
        if(!$like)
        {
            likesrembug::create([
                'id_post' => $id,
                'id_user' => auth()->user()->id
            ]);

            return response([
                'message' => 'Liked'
            ], 200);
        }
        // else dislike it
        $like->delete();

        return response([
            'message' => 'Disliked'
        ], 200);
    }
}
