<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Approver;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApproverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvers = Approver::with('user')->orderBy('level')->get();

        if (!$approvers) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'No data available',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $approvers,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request['is_default_approver'] = isset($request->is_default_approver) ? true : false;
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id|unique:approvers,user_id',
                'position' => 'required|max:255',
                'level' => 'required|numeric|min:1|max:100',
                'signature' => 'required|image',
                'is_default_approver' => 'nullable',
            ]);

            $validatedData['signature'] = $request->file('signature')->store('signatures');

            $approver = Approver::create($validatedData);
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
            'data' => $approver,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $approver = Approver::findOrFail($id);

            return response()->json([
                'statusCode' => 200,
                'message' => 'OK',
                'data' => $approver
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
            $request['is_default_approver'] = isset($request->is_default_approver) ? true : false;
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id|unique:approvers,user_id',
                'position' => 'required|max:255',
                'level' => 'required|numeric|min:1|max:100',
                'signature' => 'required|image',
                'is_default_approver' => 'nullable',
            ]);

            if ($request->file('signature')) {
                $validatedData['signature'] = $request->file('signature')->store('signatures');
            } else {
                $validatedData['signature'] = null;
            }

            $approver = Approver::findOrFail($id);
            $approver->update($validatedData);
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
            'data' => $approver,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Approver::destroy($id);

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
