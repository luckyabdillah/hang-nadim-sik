<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WorkTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workTypes = WorkType::orderBy('type')->get();

        if (!$workTypes) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'No data available',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $workTypes,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'type' => 'required|max:100',
                'unit_name' => 'required|max:100',
                'provision_text_before' => 'nullable|max:5000',
                'provision_text_after' => 'nullable|max:5000',
            ]);

            $workType = WorkType::create($validatedData);
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
            'data' => $workType,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $workType = WorkType::findOrFail($id);

            return response()->json([
                'statusCode' => 200,
                'message' => 'OK',
                'data' => $workType
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
                'type' => 'required|max:100',
                'unit_name' => 'required|max:100',
                'provision_text_before' => 'nullable|max:5000',
                'provision_text_after' => 'nullable|max:5000',
            ]);
    
            $workType = WorkType::findOrFail($id);
            $workType->update($validatedData);
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
            'data' => $workType,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $workType = WorkType::findOrFail($id);
            WorkType::destroy($workType->id);

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
