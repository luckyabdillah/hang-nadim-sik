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
        $letters = WorkPermitLetter::with('workType', 'workLocation')->where('vendor_id', 6)->get();

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
        $letter->load('vendor', 'workType', 'workLocation');

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

    /**
     * Export the specified resource.
     */
    public function exportPdf(WorkPermitLetter $letter)
    {
        $letter->load('vendor', 'workType', 'workLocation');

        $pdf = Pdf::loadView('dashboard.my.work-permit-letters.export-pdf', compact('letter'));
        return $pdf->stream('SIK-' . $letter->uuid . '.pdf');
        
        // return view('dashboard.my.work-permit-letters.show', compact('letter'));
    }

}
