<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LetterFundamental;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LetterFundamentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fundamentals = LetterFundamental::orderBy('position')->get();

        if (!$fundamentals) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'No data available',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $fundamentals,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'reference' => 'required|max:255',
                'position' => 'required|numeric|min:1',
            ]);

            $letterFundamental = LetterFundamental::create($validatedData);
        } catch (ValidationException $e) {
            return response()->json([
                'statusCode' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return response()->json([
                'statusCode' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $letterFundamental,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $letterFundamental = LetterFundamental::findOrFail($id);

            return response()->json([
                'statusCode' => 200,
                'message' => 'OK',
                'data' => $letterFundamental
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Resource not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'reference' => 'required|max:255',
                'position' => 'required|numeric|min:1',
            ]);
    
            $letterFundamental = LetterFundamental::findOrFail($id);
            $letterFundamental->update($validatedData);
        } catch (ValidationException $e) {
            return response()->json([
                'statusCode' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Resource not found'
            ], 404);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return response()->json([
                'statusCode' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $letterFundamental,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $letterFundamental = LetterFundamental::findOrFail($id);
            LetterFundamental::destroy($letterFundamental->id);

            return response()->json([
                'statusCode' => 200,
                'message' => 'OK'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Resource not found'
            ], 404);
        }
    }
}
