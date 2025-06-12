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
    //Check if the user is authenticated
    Route::get('verifySession', [AuthController::class, 'checkUserIsVerified']);

    // Posts routes
    Route::resource('posts', PostController::class);
    Route::get('posts/latest/{number}', [PostController::class, 'getLatestPosts']);
    Route::get('posts/usuario/{id}', [PostController::class, 'getPostsByUser']);

    // Entrenamientos routes
    Route::resource('entrenamientos', EntrenamientosController::class);
    Route::get('entrenamientos/usuario/{id}', [EntrenamientosController::class, 'getEntrenamientosByUsuario']);

    // Comentarios routes
    Route::resource('comentarios', ComentariosController::class);
    Route::get('comentarios/posts/{id}', [ComentariosController::class, 'getComentarioByPost']);

    // Usuario Routes
    Route::resource('usuarios', UsuarioController::class);
    Route::post('usuarios/update', [UsuarioController::class, 'updateUser']);
    Route::post('usuarios/changePassword', [UsuarioController::class, 'changePassword']);

    //Like Route
    Route::resource('likes', LikeController::class);
    Route::post('likes', [LikeController::class, 'toggleLike']);
    Route::get('likes/post/{id}', [LikeController::class, 'get_post_likes']);
    Route::get('likes/comentario/{id}', [LikeController::class, 'get_comentario_likes']);

    //Seguidores Routes
    Route::resource('seguidores', SeguidoresController::class);
    Route::get('seguidores/seguidos/{id}', [SeguidoresController::class, 'getSeguidos']);
    Route::get('seguidores/verificarSeguido/{id}', [SeguidoresController::class, 'checkSeguir']);

    //Ejercicios Routes
    Route::resource('ejercicios', EjerciciosController::class);
    Route::get('ejercicios/getAll/category', [EjerciciosController::class, 'get_AllCategory']);
    Route::get('ejercicios/getAll/muscles', [EjerciciosController::class, 'get_AllMuscleGroup']);
    Route::get('ejercicios/getAll/equipment', [EjerciciosController::class, 'get_AllEquipment']);
    Route::get('ejercicios/getAll/force', [EjerciciosController::class, 'get_AllForce']);
    Route::get('/ejercicios/getAll/filter', [EjerciciosController::class, 'filter_Excersises']);
});


