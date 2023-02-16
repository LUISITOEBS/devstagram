<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    //
    public function index() {
        return view('auth.registro');
    }

    public function store(Request $req) {
        $req->request->add(['username' => Str::slug( $req->username )]);
        //Validaciones
        $this->validate($req, [
            'name'=> ['required', 'min:3' , 'max:30' ],
            'username'=> ['required', 'min:8' , 'max:20', 'unique:users' ],
            'email'=> ['required', 'unique:users', 'email' ],
            'password'=> ['required', 'confirmed', 'min:6'],
        ]);

        //INSERT INTO: 
        User::create([
            'name' => $req->name,
            'username' => $req->username ,
            'email' => $req->email,
            'password' => Hash::make( $req->password ),
        ]);

        // auth()->attempt([
        //     'email' => $req->email ,
        //     'password' => $req->password ,
        // ]);

        //Otra forma de Autenticar
        auth()->attempt($req->only('email', 'password'));

        return redirect()->route('posts.index', auth()->user());
    }
}
