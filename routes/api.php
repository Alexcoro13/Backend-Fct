<?php

use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrenamientosController;


// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'LogIn']);
Route::get('logout', [AuthController::class, 'logOut'])->middleware('auth:sanctum');

// Post routes
Route::resource('posts', PostController::class)->middleware('auth:sanctum');

//Entrenamientos routes
Route::resource('entrenamientos', EntrenamientosController::class)->middleware('auth:sanctum');
Route::get('entrenamientos/usuario/{id}', [EntrenamientosController::class, 'getEntrenamientosByUsuario'])->middleware('auth:sanctum');

//Comentarios routes
Route::resource('comentarios', ComentariosController::class)->middleware('auth:sanctum');
Route::get('comentarios/posts/{id}', [ComentariosController::class, 'getComentarioByPost'])->middleware('auth:sanctum');

// Usuario Routes
Route::resource('usuarios', UsuarioController::class)->middleware('auth:sanctum');

//Like Routes
Route::resource('likes', LikeController::class)->middleware('auth:sanctum');
Route::get('likes/post/{id}', [LikeController::class, 'get_post_likes'])->middleware('auth:sanctum');
Route::get('likes/comentario/{id}', [LikeController::class, 'get_comentario_likes'])->middleware('auth:sanctum');
