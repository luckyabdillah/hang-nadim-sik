<?php

namespace App\Http\Controllers\Dashboard\My;

use App\Http\Controllers\Controller;
use App\Models\WorkPermitLetter;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class WorkPermitLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letters = WorkPermitLetter::with([
            'vendor' => function ($query) {
                $query->withTrashed();
            },
            'workType' => function ($query) {
                $query->withTrashed();
            },
            'workLocation' => function ($query) {
                $query->withTrashed();
            },
        ])->where('vendor_id', 1)->get();

        return view('dashboard.my.work-permit-letters.index', compact('letters'));
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
    public function show(WorkPermitLetter $letter)
    {
        $letter->load([
            'vendor' => function ($query) {
                $query->withTrashed();
            },
            'workType' => function ($query) {
                $query->withTrashed();
            },
            'workLocation' => function ($query) {
                $query->withTrashed();
            },
        ]);

        return view('dashboard.my.work-permit-letters.show', compact('letter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkPermitLetter $letter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkPermitLetter $letter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkPermitLetter $letter)
    {
        //
    }
}
