<?php

use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\EjerciciosController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SeguidoresController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrenamientosController;


// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'LogIn']);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

Route::get('logout', [AuthController::class, 'logOut'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('posts', PostController::class);

    // Entrenamientos routes
    Route::resource('entrenamientos', EntrenamientosController::class);
    Route::get('entrenamientos/usuario/{id}', [EntrenamientosController::class, 'getEntrenamientosByUsuario']);

    // Comentarios routes
    Route::resource('comentarios', ComentariosController::class);
    Route::get('comentarios/posts/{id}', [ComentariosController::class, 'getComentarioByPost']);

    // Usuario Routes
    Route::resource('usuarios', UsuarioController::class);

    //Like Routes
    Route::resource('likes', LikeController::class);
    Route::get('likes/post/{id}', [LikeController::class, 'get_post_likes']);
    Route::get('likes/comentario/{id}', [LikeController::class, 'get_comentario_likes']);

    //Seguidores Routes
    Route::resource('seguidores', SeguidoresController::class);
    Route::get('seguidores/seguidos/{id}', [SeguidoresController::class, 'getSeguidos']);

    //Ejercicios Routes
    Route::resource('ejercicios', EjerciciosController::class);
    Route::get('ejercicios/category/{id}', [EjerciciosController::class, 'get_byCategory']);
    Route::get('ejercicios/muscleGroup/{muscleGroup}', [EjerciciosController::class, 'get_byMuscleGroup']);
    Route::get('ejercicios/equipment/{equipment}', [EjerciciosController::class, 'get_byEquipment']);
    Route::get('ejercicios/force/{force}', [EjerciciosController::class, 'get_byForce']);
});


