<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Copy;
use Illuminate\Http\Request;

class CopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $copies = Copy::orderBy('name')->get();

        return view('dashboard.copies.index', compact('copies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.copies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:150',
        ]);

        Copy::create($validatedData);

        return redirect('/dashboard/copies')->with('success', 'Copy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Copy $copy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Copy $copy)
    {
        return view('dashboard.copies.edit', compact('copy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Copy $copy)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:150',
        ]);

        $copy->update($validatedData);

        return redirect('/dashboard/copies')->with('success', 'Copy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Copy $copy)
    {
        Copy::destroy($copy->id);

        return redirect('/dashboard/copies')->with('success', 'Copy deleted successfully');
    }
}
