<?php

use App\Http\Controllers\ActualizacionController;
use App\Http\Controllers\AuxController;
use App\Http\Controllers\DefectuosoController;
use App\Http\Controllers\DonacionController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\RebajaController;
use App\Http\Controllers\TrasladoController;
use App\Http\Controllers\VentaTransferenciaController;
use App\Models\Editorial;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/setup', function () {
    $generos = ['Adivinanza', 'Antología histórica', 'Antología poética', 'Autoayuda', 'Aventura'
        , 'Biografía', 'Bibliografía', 'Cine', 'Colorear', 'Compilación', 'Compilación histórica'
        , 'Crónica', 'Cronología', 'Cuento', 'Cuentos infantiles', 'Cuento de ficción', 'Diccionario'
        , 'Divulgación', 'Divulgación científica', 'Divulgación cinematográfica', 'Divulgación culinaria'
        , 'Divulgación deportiva', 'Divulgación histórica', 'Enciclopedia biográfica', 'Ensayo', 'Ensayo histórico'
        , 'Epistolario', 'Gaceta', 'Historia', 'Historieta', 'Historia del deporte', 'Investigación'
        , 'Investigación histórica', 'Investigación jurídica', 'Leyenda', 'Mapas', 'Narración', ' Novela', 'Novela fantástica'
        , 'Novela de ficción', 'Novela francesa', 'Novela histórica', 'Novela poética', 'Novela polaca', 'Novela policiaca'
        , 'Novela policiaca juvenil', 'Ortografía', 'Poesía', 'Recreación', 'Relato', 'Teatro', 'Testimonio'];
    foreach ($generos as $genero) {
        Genero::create(['genero' => $genero]);
    }
    $editoriales = ['Abril', 'Acana', 'Academia', 'Aldabon', 'Ancoras', 'Arte y Literatura', 'Caminos', 'Capitán San Luis'
        , 'Capiro', 'Casa de las Américas', 'Cauce', 'Ciencias Sociales', 'Científico Técnica', 'Colección Sur', 'Concejo de estado'
        , 'De la mujer', 'Deportes', 'El Abra', 'El mar y la montaña', 'Estudios martianos', 'Extramuro', 'Filosofía', 'Fundación Fernando Ortiz'
        , 'Gente Nueva', 'Geo', 'Historia de Cuba', 'Holguín', 'ICAIC', 'Imagen Contemporánea', 'José Martí', 'La luz', 'La memoria'
        , 'Letras Cubanas', 'Liber', 'Loynaz', 'Luminaria', 'Matanzas', 'ONBC', 'Oriente', 'Pablo de la Torriente', 'Política'
        , 'Pueblo y educación', 'Santiago', 'Sed de belleza', 'Sensemaya', 'UNEAC', 'Unión', 'Verde Olivo'];
    foreach ($editoriales as $editorial) {
        Editorial::create(['editorial' => $editorial]);
    }

    return response()->json([
        'msg' => 'OK'
    ], 200);
});

Route::group(['prefix' => 'libro'], function () {
    Route::get('/index', [LibroController::class, 'index'])->name('index.libro.api');
    Route::get('/show/{libro}', [LibroController::class, 'show'])->name('show.libro.api');
    Route::post('/store', [LibroController::class, 'store'])->name('store.libro.api');
    Route::put('/update/{libro}', [LibroController::class, 'update'])->name('update.libro.api');
});

Route::group(['prefix' => 'editorial'], function () {
    Route::get('/index', [EditorialController::class, 'index'])->name('index.editorial.api');
    Route::get('/show/{editorial}', [EditorialController::class, 'show'])->name('show.editorial.api');
    Route::post('/store', [EditorialController::class, 'store'])->name('store.editorial.api');
    Route::put('/update/{editorial}', [EditorialController::class, 'update'])->name('update.editorial.api');
    Route::delete('/destroy/{editorial}', [EditorialController::class, 'destroy'])->name('destroy.editorial.api');
});

Route::group(['prefix' => 'genero'], function () {
    Route::get('/index', [GeneroController::class, 'index'])->name('index.genero.api');
    Route::get('/show/{genero}', [GeneroController::class, 'show'])->name('show.genero.api');
    Route::post('/store', [GeneroController::class, 'store'])->name('store.genero.api');
    Route::put('/update/{genero}', [GeneroController::class, 'update'])->name('update.genero.api');
    Route::delete('/destroy/{genero}', [GeneroController::class, 'destroy'])->name('destroy.genero.api');
});

Route::group(['prefix' => 'actualizacion'], function () {
    Route::get('/show/{libro}', [ActualizacionController::class, 'show'])->name('show.actualizacion.api');
    Route::post('/store/{libro}', [ActualizacionController::class, 'store'])->name('store.actualizacion.api');
});

Route::group(['prefix' => 'defectuoso'], function () {
    Route::get('/index', [DefectuosoController::class, 'index'])->name('index.defectuoso.api');
    Route::get('/show/{libro}', [DefectuosoController::class, 'show'])->name('show.defectuoso.api');
    Route::post('/store/{libro}', [DefectuosoController::class, 'store'])->name('store.defectuoso.api');
});

Route::group(['prefix' => 'donacion'], function () {
    Route::get('/index', [DonacionController::class, 'index'])->name('index.donacion.api');
    Route::get('/show/{libro}', [DonacionController::class, 'show'])->name('show.donacion.api');
    Route::post('/store/{libro}', [DonacionController::class, 'store'])->name('store.donacion.api');
});

Route::group(['prefix' => 'rebaja'], function () {
    Route::get('/index', [RebajaController::class, 'index'])->name('index.rebaja.api');
    Route::get('/show/{libro}', [RebajaController::class, 'show'])->name('show.rebaja.api');
    Route::post('/store/{libro}', [RebajaController::class, 'store'])->name('store.rebaja.api');
});

Route::group(['prefix' => 'traslado'], function () {
    Route::get('/index', [TrasladoController::class, 'index'])->name('index.traslado.api');
    Route::get('/show/{libro}', [TrasladoController::class, 'show'])->name('show.traslado.api');
    Route::post('/store/{libro}', [TrasladoController::class, 'store'])->name('store.traslado.api');
});

Route::group(['prefix' => 'venta'], function () {
    Route::get('/index', [VentaTransferenciaController::class, 'index'])->name('index.venta.api');
    Route::get('/show/{libro}', [VentaTransferenciaController::class, 'show'])->name('show.venta.api');
    Route::post('/store/{libro}', [VentaTransferenciaController::class, 'store'])->name('store.venta.api');
});

Route::group(['prefix' => 'aux'], function () {
    Route::get('/lento_mov', [AuxController::class, 'slowMovement'])->name('slowMovement.aux.api');
    Route::get('/search', [AuxController::class, 'search'])->name('search.aux.api');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
