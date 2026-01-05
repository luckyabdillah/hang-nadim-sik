<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Copy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $copies = Copy::orderBy('name')->get();

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $copies,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:150',
                'email' => 'required|email:rfc,dns',
                'send_email' => 'nullable|boolean',
            ]);

            $copy = Copy::create($validatedData);
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
            'data' => $copy,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $copy = Copy::findOrFail($id);

            return response()->json([
                'statusCode' => 200,
                'message' => 'OK',
                'data' => $copy
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
                'name' => 'required|max:150',
                'email' => 'required|email:rfc,dns',
                'send_email' => 'required|boolean',
            ]);
    
            $copy = Copy::findOrFail($id);
            $copy->update($validatedData);
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
            'data' => $copy,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $copy = Copy::findOrFail($id);
            Copy::destroy($copy->id);

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
