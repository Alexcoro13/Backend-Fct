<?php

namespace App\Http\Controllers;

use App\Models\Ejercicios;
use Exception;
use Illuminate\Http\Request;

class EjerciciosController extends Controller
{
    public function index()
    {
        $ejercicios = Ejercicios::all();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function show($id)
    {
        try {
            $ejercicio = Ejercicios::where('name', 'like', '%' . $id . '%')->firstOrFail();

            return response()->json(
                [
                    'data' => $ejercicio,
                    'message' => 'Ejercicio encontrado'
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'data' => null, 'message' => 'Ejercicio no encontrado',
                    'error' => $e->getMessage()
                ],
                404
            );
        }
    }

    public function get_AllMuscleGroup()
    {
        $ejercicios = Ejercicios::pluck('primaryMuscles')->unique()->values();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function get_AllEquipment()
    {
        $ejercicios = Ejercicios::pluck('equipment')->unique()->values();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function get_AllCategory()
    {
        $ejercicios = Ejercicios::pluck('category')->unique()->values();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function get_AllForce()
    {
        $ejercicios = Ejercicios::pluck('force')->unique()->values();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function filter_Excersises(Request $request)
    {
        $query = Ejercicios::query();

        if ($request->has('force') && $request->force !== '') {
            $query->where('force', 'like', '%' . $request->force . '%');
        }

        if ($request->has('category') && $request->category !== '') {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        if ($request->has('equipment') && $request->equipment !== '') {
            $query->where('equipment', 'like', '%' . $request->equipment . '%');
        }

        if ($request->has('muscle') && $request->muscle !== '') {
            $query->where('primaryMuscles', 'like',  '%' . $request->muscle . '%');
        }

        $ejercicios = $query->get();

        return response()->json([
            'data' => $ejercicios,
            'request' => $request->all(),
            'message' => count($ejercicios) > 0 ? 'Ejercicios encontrados' : 'No se encontraron ejercicios'
        ], 200);
    }
}
