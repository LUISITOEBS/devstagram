<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['show', 'index']);
    }


    public function index(User $user){
        $posts = Post::where('user_id', $user->id)->latest()->paginate(8); //simplePaginate
        return view('private.dashboard', [ 'user' => $user, 'posts' => $posts ]);
    }

    public function create(){
        return view('private.posts.create');
    }

    public function store(Request $req){
        $this->validate($req, [
            'titulo'=> ['required', 'min:3' , 'max:255' ],
            'descripcion'=> ['required', 'min:8' , 'max:1000' ],
            'imagen'=> [ 'required' ],
        ]);

        //INSERT INTO: 
        // Post::create([
        //     'titulo' => $req->titulo,
        //     'descripcion' => $req->descripcion ,
        //     'imagen' => $req->imagen,
        //     'user_id' => auth()->user()->id,
        // ]);

        //Otra forma
        // $post = new Post;
        // $post->titulo = $req->titulo;
        // $post->descripcion = $req->descripcion;
        // $post->imagen = $req->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();


        //Otra forma
        $req->user()->posts()->create([
            'titulo' => $req->titulo,
            'descripcion' => $req->descripcion ,
            'imagen' => $req->imagen,
            'user_id' => auth()->user()->id,
        ]);


        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post ){
        return view('private.posts.show', ['post' => $post, 'user' => $user]);
    }

    public function destroy(Post $post ){
        $this->authorize('delete', $post);
        $post->delete();

        //Eliminar la imagen
        $imagenPath = public_path('uploads/' . $post->imagen);
        if(File::exists($imagenPath)){
            unlink($imagenPath);
        }
        return  redirect()->route('posts.index', auth()->user()->username);
    }
}
