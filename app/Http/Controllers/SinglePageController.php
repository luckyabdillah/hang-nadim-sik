<?php

namespace App\Http\Controllers;

use App\Models\WorkPermitLetter;
use Illuminate\Http\Request;

class SinglePageController extends Controller
{
   public function index()
    {
        return view('index');
    }

    public function sik()
    {
        $workPermitLetters = WorkPermitLetter::with('vendor')->orderBy('started_at', 'desc')->get();

        return view('sik', compact('workPermitLetters'));
    }

    public function contact()
    {
        return view('contact');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
