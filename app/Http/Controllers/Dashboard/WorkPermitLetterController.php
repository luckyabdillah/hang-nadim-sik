<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ApprovalStage;
use App\Models\Approver;
use App\Models\WorkPermitLetter;
use Illuminate\Http\Request;

class WorkPermitLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letters = WorkPermitLetter::with('vendor', 'workType', 'workLocation')->get();

        return view('dashboard.work-permit-letters.index', compact('letters'));
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
        $approvers = Approver::orderBy('level')->get();
        $stages = ApprovalStage::where('work_permit_letter_id', $letter->id)->orderBy('level')->get();

        return view('dashboard.work-permit-letters.show', compact('letter', 'approvers', 'stages'));
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
        $validatedData = $request->validate([
            'approvers' => 'required',
            'internal_pic_name' => 'required|max:150',
            'internal_pic_number' => 'required|max:15',
        ]);

        foreach ($validatedData['approvers'] as $approverId) {
            $approver = Approver::firstWhere('id', $approverId);
            $approvalStage = ApprovalStage::create([
                'work_permit_letter_id' => $letter->id,
                'approver_id' => $approver->id,
                'position' => $approver->position,
                'level' => $approver->level,
                'signature' => $approver->signature,
            ]);

            // Send email to each approver
        }

        $validatedData['status'] = 'verified';
        $letter->update($validatedData);

        return redirect()->route('dashboard.work-permit-letters.show', ['letter' => $letter->uuid])->with('success', 'SIK berhasil diverifikasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, WorkPermitLetter $letter)
    {
        $validatedData = $request->validate([
            'notes' => 'required|max:255',
        ]);
        $validatedData['status'] = 'rejected';

        $letter->update($validatedData);

        return redirect()->route('dashboard.work-permit-letters.show', ['letter' => $letter->uuid])->with('success', 'SIK berhasil ditolak');
    }
}
