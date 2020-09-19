<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $libros = Libro::with('traslados')
            ->has('traslados')->where('cantidad', '>', 0)->get();
        foreach ($libros as $libro) {
            $traslados = $libro->getRelation('traslados');
            $cantidad = 0;
            foreach ($traslados as $traslado) {
                $cantidad += $traslado->cantidad;
            }
            $libro->cantidad = $cantidad;
            $libro->importe = $cantidad * $libro->precio;
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
            'cantidad' => 'required|numeric',
            'para' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $cantidad = $request->get('cantidad');
        $libro->update([
            'cantidad' => $libro->cantidad - $cantidad
        ]);

        $data = $request->all();
        $data['precio'] = $libro->precio;
        $libro->traslados()->create($data);

        return response()->json([
            'mensaje' => 'Traslado Registrado.',
            'traslados' => $libro->refresh()->traslados()->get()
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
        if (count($libro->traslados()->get()) > 0) {
            return response()->json([
                'traslados' => $libro->traslados()->get()
            ], 200);
        } else {
            return response()->json([
                'mensaje' => 'El libro no cuenta con registros de traslados.'
            ], 200);
        }
    }
}
