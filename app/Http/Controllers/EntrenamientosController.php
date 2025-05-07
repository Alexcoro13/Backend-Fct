<?php

namespace App\Http\Controllers;

use App\Models\Entrenamiento;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\EntrenamientoRequest;

class EntrenamientosController extends Controller
{
    public function index(): JsonResponse{
        try{
            $entrenamientos = Entrenamiento::all();

            return response()->json(['data' => $entrenamientos, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Entrenamientos not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function show($id): JsonResponse{
        try{
            $entrenamiento = Entrenamiento::findOrFail($id);

            return response()->json(['data' => $entrenamiento, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Entrenamiento not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function store(EntrenamientoRequest $request): JsonResponse{
        try{
            $entrenamiento = new Entrenamiento();

            $entrenamiento->ejercicios = $request->ejercicios;
            $entrenamiento->descripcion = $request->descripcion;
            $entrenamiento->duracion = $request->duracion;
            $entrenamiento->id_usuario = auth()->user()->id;
            $entrenamiento->nombre = $request->nombre;

            $entrenamiento->saveOrFail();

            return response()->json(['data' => $entrenamiento, 'message' => 'Entrenamiento created successfully'], 201);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Error creating Entrenamiento', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(EntrenamientoRequest $request, $id): JsonResponse{
        try{
            $entrenamiento = Entrenamiento::findOrFail($id);

            $entrenamiento->ejercicios = $request->ejercicios;
            $entrenamiento->descripcion = $request->descripcion;
            $entrenamiento->duracion = $request->duracion;
            $entrenamiento->id_usuario = auth()->user()->id;
            $entrenamiento->nombre = $request->nombre;

            $entrenamiento->saveOrFail();

            return response()->json(['data' => $entrenamiento, 'message' => 'Entrenamiento updated successfully'], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Error updating Entrenamiento', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse{
        try{
            $entrenamiento = Entrenamiento::findOrFail($id);

            $entrenamiento->delete();

            return response()->json(['data' => null, 'message' => 'Entrenamiento deleted successfully'], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Error deleting Entrenamiento', 'error' => $e->getMessage()], 500);
        }
    }
}
