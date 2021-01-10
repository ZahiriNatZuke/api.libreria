<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use App\Models\Genero;
use App\Models\Libro;
use App\Rules\arrayGendersValid;
use App\Rules\editorialValid;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'libros' => Libro::query()->where('cantidad', '>', 0)->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ResponseFactory|JsonResponse|Response
     */
    public function store(Request $request)
    {
        $validator = $this->ValidateRequest($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $libro = new Libro();

        $libro->fill($request->all());
        if ($request->get('editorial')){
            $libro->fill([
                'editorial_id' => Editorial::query()
                    ->where('editorial', $request->get('editorial'))->first()->id
            ]);
        }

        $libro->save();

        if ($request->get('generos')) {
            $array = explode(',', $request->get('generos'));
            foreach ($array as $item) {
                $temp = Genero::query()->where('genero', trim($item))->first();
                $libro->generos()->toggle($temp);
            }
        }

        return response()->json([
            'libro' => $libro->refresh()
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
        return response()->json([
            'libro' => $libro->load([
                'actualizaciones',
                'defectuosos',
                'donaciones',
                'rebajas',
                'traslados',
                'ventaTransferencias',
                'generos'
            ])
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Libro $libro
     * @return JsonResponse|Response
     */
    public function update(Request $request, Libro $libro)
    {
        $validator = $this->ValidateRequest($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $libro->update($request->all());

        if ($request->get('editorial'))
            $libro->update([
                'editorial_id' => Editorial::query()
                    ->where('editorial', $request->get('editorial'))->first()->id
            ]);

        if ($request->get('generos')) {
            $array = explode(',', $request->get('generos'));

            foreach ($array as $item) {
                $temp = Genero::query()->where('genero', trim($item))->first();
                $libro->generos()->syncWithoutDetaching($temp);
            }
        }

        return response()->json([
            'libro' => $libro->refresh()
        ], 200);
    }

    /**
     * @param array $values
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function ValidateRequest(array $values)
    {
        return Validator::make($values, [
            'titulo' => 'required|string',
            'autor' => 'nullable|string',
            'anno' => 'nullable|numeric',
            'generos' => ['nullable', new arrayGendersValid],
            'editorial' => ['nullable', new editorialValid],
            'precio' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'categoria' => ['nullable', 'string', Rule::in(['Población', 'Ediciones Matanzas', 'Revistas', 'EGREM', 'Misceláneas'])],
        ]);
    }
}
