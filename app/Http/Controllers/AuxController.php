<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuxController extends Controller
{
    /**
     * Display a listing of the resource from slow movement.
     *
     * @return JsonResponse
     */
    public function slowMovement()
    {
        return response()->json([
            'libros' => Libro::query()
                ->where('cantidad', '>', 0)
                ->where('anno', '<=', now()->year - 5)
                ->get()
        ], 200);
    }

    /**
     * Display a listing of the resource from a search query.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->query->all();

        $titulo = array_key_exists('titulo', $query) ? $query['titulo'] : '';
        $categoria = array_key_exists('categoria', $query) ? $query['categoria'] : '';
        $generos = array_key_exists('generos', $query) ? explode(',', $query['generos']) : [];
        $editorial = array_key_exists('editorial', $query) ? $query['editorial'] : '';

        $base = Libro::query()->where('cantidad', '>', 0);

        if ($titulo)
            $base = $base->where('titulo', 'LIKE', '%' . $titulo . '%');

        if ($categoria)
            $base = $base->where('categoria', $categoria);

        if (count($generos) > 0)
            $base = $base->whereHas('generos', static function (Builder $builder) use ($generos) {
                $builder->whereIn('genero', $generos);
            });

        if ($editorial)
            $base = $base->whereHas('editorial', static function (Builder $builder) use ($editorial) {
                $builder->where('editorial', $editorial);
            });

        return response()->json([
            'libros' => $base->get(),
            'query' => $query
        ], 200);
    }

}
