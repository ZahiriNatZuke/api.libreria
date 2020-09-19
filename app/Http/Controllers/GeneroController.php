<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        return response()->json([
            'generos' => Genero::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'genero' => 'string|unique:generos'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $genero = new Genero();
        $genero->fill([
            'genero' => $request->get('genero')
        ]);
        $genero->save();

        return response()->json([
            'genero' => $genero
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Genero $genero
     * @return JsonResponse
     */
    public function show(Genero $genero)
    {
        return response()->json([
            'genero' => $genero
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Genero $genero
     * @return JsonResponse
     */
    public function update(Request $request, Genero $genero)
    {
        $validator = Validator::make($request->all(), [
            'genero' => 'string|unique:generos'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $genero->update($request->all());

        return response()->json([
            'genero' => $genero->refresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Genero $genero
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Genero $genero)
    {
        $genero->delete();
        return response()->json([
            'genero_deleted' => $genero
        ], 200);
    }
}
