<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\LetterFundamental;
use Illuminate\Http\Request;

class LetterFundamentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fundamentals = LetterFundamental::orderBy('position')->get();

        return view('dashboard.letter-fundamentals.index', compact('fundamentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $totalFundamental = LetterFundamental::count();

        return view('dashboard.letter-fundamentals.create', compact('totalFundamental'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reference' => 'required|max:255',
            'position' => 'required|numeric|min:1',
        ]);

        LetterFundamental::create($validatedData);

        return redirect()->route('dashboard.letter-fundamentals.index')->with('success', 'Data berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(LetterFundamental $fundamental)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterFundamental $fundamental)
    {
        return view('dashboard.letter-fundamentals.edit', compact('fundamental'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LetterFundamental $fundamental)
    {
        $validatedData = $request->validate([
            'reference' => 'required|max:255',
            'position' => 'required|numeric|min:1',
        ]);

        $fundamental->update($validatedData);

        return redirect()->route('dashboard.letter-fundamentals.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterFundamental $fundamental)
    {
        LetterFundamental::destroy($fundamental->id);

        return redirect()->route('dashboard.letter-fundamentals.index')->with('success', 'Data berhasil dihapus');
    }
}
