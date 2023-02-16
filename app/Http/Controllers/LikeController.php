<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post){
        Like::create([
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ]);

        return back();
    }

    public function destroy(Request $req, Post $post){
        $req->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
