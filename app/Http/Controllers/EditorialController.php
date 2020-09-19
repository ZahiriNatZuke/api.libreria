<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        return response()->json([
            'editoriales' => Editorial::all()
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
            'editorial' => 'string|unique:editoriales'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $editorial = new Editorial();
        $editorial->fill([
            'editorial' => $request->get('editorial')
        ]);
        $editorial->save();

        return response()->json([
            'editorial' => $editorial
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Editorial $editorial
     * @return JsonResponse
     */
    public function show(Editorial $editorial)
    {
        return response()->json([
            'editorial' => $editorial
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Editorial $editorial
     * @return JsonResponse
     */
    public function update(Request $request, Editorial $editorial)
    {
        $validator = Validator::make($request->all(), [
            'editorial' => 'string|unique:editoriales'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $editorial->update($request->all());

        return response()->json([
            'editorial' => $editorial->refresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Editorial $editorial
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Editorial $editorial)
    {
        $editorial->delete();
        return response()->json([
            'editorial_deleted' => $editorial
        ], 200);
    }
}
