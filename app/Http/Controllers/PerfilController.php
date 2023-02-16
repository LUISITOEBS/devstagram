<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('perfil.index');
    }

    public function store( Request $req ){
        $req->request->add(['username' => Str::slug( $req->username )]);
        $this->validate($req, [
            'username'=> ['required', 'min:8' , 'max:20', 'unique:users,username,' .auth()->user()->id, 'not_in:twitter,editar-perfil'],
        ]);

        if($req->imagen){
            $imagen = $req->file('imagen');
            $nombreImagen = Str::uuid().".". $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $req->username;
        $usuario->imagen =$nombreImagen ?? auth()->user()->imagen ?? '';
        $usuario->save();

        return redirect(route('posts.index', $usuario->username));
    }
    
}
