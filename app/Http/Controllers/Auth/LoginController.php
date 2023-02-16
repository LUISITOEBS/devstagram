<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function store(Request $req){

        $this->validate($req, [
            'email'=> [ 'required', 'email' ],
            'password'=> [ 'required' ] ,
        ]);
    

        $state = auth()->attempt($req->only('email', 'password'), $req->remember);
        if($state){
            return redirect()->route('posts.index', auth()->user() );
        }

        return back()->with('mensaje', 'El email o el password son incorrectos');
    }
}
