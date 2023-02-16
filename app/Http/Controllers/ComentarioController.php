<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(User $user, Post $post, Request $req){
        $this->validate($req, [
            'comentario'=> ['required', 'min:3' , 'max:255' ],
        ]);


        Comentario::create([
            'comentario' => $req->comentario,
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ]);

        return back()->with('mensaje','Comentario publicado');
    }
}
