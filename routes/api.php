<?php

use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrenamientosController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'LogIn']);
Route::get('logout', [AuthController::class, 'logOut'])->middleware('auth:sanctum');

// Post routes
Route::resource('posts', PostController::class)->middleware('auth:sanctum');

//Entrenamientos routes
Route::resource('entrenamientos', EntrenamientosController::class)->middleware('auth:sanctum');

//Comentarios routes
Route::resource('comentarios', ComentariosController::class)->middleware('auth:sanctum');
Route::get('comentarios/posts/{id}', [ComentariosController::class, 'getComentarioByPost'])->middleware('auth:sanctum');
