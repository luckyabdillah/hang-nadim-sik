<?php

namespace App\Http\Controllers\Dashboard\My;

use App\Http\Controllers\Controller;
use App\Models\WorkLocation;
use App\Models\WorkPermitLetter;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class WorkPermitLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = auth()->user()->applicant->vendor;
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
        ])->where('vendor_id', $vendor->id)->get();

        return view('dashboard.my.work-permit-letters.index', compact('letters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $workLocations = WorkLocation::all();
        $workTypes = WorkType::all();
        
        return view('dashboard.my.work-permit-letters.create', compact('workLocations', 'workTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vendor = auth()->user()->applicant->vendor;
        $validatedData = $request->validate([
            'work_location_id' => 'required|numeric|exists:work_locations,id',
            'work_type_id' => 'required|numeric|exists:work_types,id',
            'started_at' => 'required|date|after_or_equal:today',
            'ended_at' => 'required|date|after:started_at',
            'description' => 'required|max:255',
            'external_pic_name' => 'required|max:150',
            'external_pic_number' => 'required|numeric|max_digits:12',
            'application_letter' => 'required|file|mimes:pdf|max:4096',
            'job_safety_analysis_document' => 'nullable|file|mimes:pdf|max:4096'
        ]);

        $validatedData['external_pic_number'] = '+62' . $validatedData['external_pic_number'];

        $validatedData['vendor_id'] = $vendor->id;
        $validatedData['application_letter'] = $request->file('application_letter')->store('application_letters');
        if ($request->file('job_safety_analysis_document')) {
            $validatedData['job_safety_analysis_document'] = $request->file('job_safety_analysis_document')->store('jsa_documents');
        }

        WorkPermitLetter::create($validatedData);

        return redirect('/dashboard/my/work-permit-letters')->with('success', 'Data berhasil dibuat');
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
