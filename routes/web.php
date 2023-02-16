<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PerfilController;



//REGISTRO - LOGIN - LOGOUT
Route::get('/', HomeController::class)->name('home');
Route::get('/registro', [RegistroController::class, 'index'])->name('register');
Route::post('/registro', [RegistroController::class, 'store']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'index'])->name('logout');


Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');


//PERFILES-MURO-POST
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

//IMAGENES
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

//LIKES
Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('like.store');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('like.delete');

//PERFILES-COMENTARIOS
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

//SEGUIDORES
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

