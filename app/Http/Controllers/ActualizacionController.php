<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ActualizacionController extends Controller
{

    /**
     * Display the list from specified resource.
     *
     * @param Libro $libro
     * @return JsonResponse
     */
    public function show(Libro $libro)
    {
        if (count($libro->actualizaciones()->get()) > 0) {
            return response()->json([
                'actualizaciones' => $libro->actualizaciones()->get()
            ], 200);
        } else {
            return response()->json([
                'mensaje' => 'El libro no cuenta con registros de actualización.'
            ], 200);
        }
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
            'accion' => ['required', Rule::in(['Entrada', 'Venta'])],
            'cantidad' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $accion = $request->get('accion');
        $cantidad = $request->get('cantidad');
        $libro->update([
            'cantidad' => $accion === 'Entrada' ? $libro->cantidad + $cantidad : $libro->cantidad - $cantidad
        ]);

        $data = $request->all();
        $data['precio'] = $libro->precio;
        $libro->actualizaciones()->create($data);

        return response()->json([
            'mensaje' => 'Actualizacion Registrada.',
            'actualizaciones' => $libro->refresh()->actualizaciones()->get()
        ], 201);
    }

}
