<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RebajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $libros = Libro::with('rebajas')
            ->has('rebajas')->where('cantidad', '>', 0)->get();
        foreach ($libros as $libro) {
            $rebaja = $libro->getRelation('rebajas')->first();
            $libro['viejo_precio'] = $rebaja->viejo_precio;
        }
        return response()->json([
            'libros' => $libros
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Libro $libro
     * @return JsonResponse
     */
    public function store(Request $request, Libro $libro)
    {
        $validator = Validator::make($request->all(), [
            'nuevo_precio' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $data = $request->all();
        $data['viejo_precio'] = $libro->precio;
        $data['cantidad'] = $libro->cantidad;
        $libro->rebajas()->create($data);

        $libro->update([
            'precio' => $request->get('nuevo_precio')
        ]);

        return response()->json([
            'mensaje' => 'Rebaja Registrada.',
            'rebajas' => $libro->refresh()->rebajas()->get()
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Libro $libro
     * @return JsonResponse
     */
    public function show(Libro $libro)
    {
        if (count($libro->rebajas()->get()) > 0) {
            return response()->json([
                'rebajas' => $libro->rebajas()->get()
            ], 200);
        } else {
            return response()->json([
                'mensaje' => 'El libro no cuenta con registros de rebajas.'
            ], 200);
        }
    }
}
