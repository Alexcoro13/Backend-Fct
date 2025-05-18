<?php

namespace App\Http\Controllers;

use App\Models\Ejercicios;
use Exception;

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
        try{
            $ejercicio = Ejercicios::where('name', 'like', '%' . $id . '%')->firstOrFail();

            return response()->json(
                [
                    'data' => $ejercicio,
                    'message' => 'Ejercicio encontrado'
                ],
                200
            );
        }
        catch (Exception $e){
            return response()->json(
                [
                    'data'=> null, 'message' => 'Ejercicio no encontrado',
                    'error' => $e->getMessage()
                ],
                404
            );
        }
    }

    public function get_byMuscleGroup($muscleGroup)
    {
        $ejericios = Ejercicios::where('primaryMuscles', 'like', '%' . $muscleGroup . '%')->get();

        return response()->json(
            [
                'data' => $ejericios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function get_byEquipment($equipment)
    {
        $ejercicios = Ejercicios::where('equipment', 'like', '%' . $equipment . '%')->get();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function get_byCategory($category)
    {
        $ejercicios = Ejercicios::where('category', 'like', '%' . $category . '%')->get();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }

    public function get_byForce($name){
        $ejercicios = Ejercicios::where('force', 'like', '%' . $name . '%')->get();

        return response()->json(
            [
                'data' => $ejercicios,
                'message' => 'Ejercicios encontrados'
            ],
            200
        );
    }
}
