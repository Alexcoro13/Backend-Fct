<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrenamiento;

class EntrenamientosController extends Controller
{
    public function index(){
        try{
            $entrenamientos = Entrenamiento::all();

            return response()->json(['data' => $entrenamientos, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Entrenamientos not found', 'error' => $e->getMessage()], 404);
        }
    }
}
