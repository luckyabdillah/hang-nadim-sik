<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ApprovalStage;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = ApprovalStage::with([
            'workPermitLetter.vendor',
            'workPermitLetter.workType',
            'workPermitLetter.workLocation',
        ])->get();

        return view('dashboard.approvals.index', compact('stages'));
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
    public function show(ApprovalStage $stage)
    {
        $stage->load([
            'workPermitLetter.vendor',
            'workPermitLetter.workType',
            'workPermitLetter.workLocation',
        ]);

        return view('dashboard.approvals.show', compact('stage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApprovalStage $stage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApprovalStage $stage)
    {
        $rules = [
            'status' => 'required|in:approved,rejected',
            'notes' => 'required_if:status,rejected|max:500'
        ];

        $validatedData = $request->validate($rules);

        $stage->update($validatedData);
        $stage->workPermitLetter->update([
            'status' => $stage->status,
            'notes' => $stage->notes,
        ]);
        
        $approvalStepCompletion = false;
        if ($request->status == 'approved') {
            $stage->update(['notes' => null]);
            $stage->workPermitLetter->update(['notes' => null]);
            $approvalStepCompletion = true;
            $anotherStages = ApprovalStage::where('work_permit_letter_id', $stage->workPermitLetter->id)->where('id', '!=', $stage->id)->orderBy('level')->get();
            foreach ($anotherStages as $anotherStage) {
                if ($anotherStage->status == 'waiting') {
                    $approvalStepCompletion = false;
                    $stage->workPermitLetter->update(['status' => 'verified']);
                } elseif ($anotherStage->status == 'rejected') {
                    $approvalStepCompletion = false;
                    $stage->workPermitLetter->update([
                        'status' => 'rejected',
                        'notes' => $anotherStage->notes,
                    ]);
                } else {
                    $stage->workPermitLetter->update(['status' => 'approved']);
                }
            }
        }

        if ($approvalStepCompletion) {
            // Generate QR Code
            // Publish & Activate SIK
            // Send mail to vendor
        }

        return redirect()->route('dashboard.approvals.show', ['stage' => $stage->id])->with('success', 'SIK berhasil disetujui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApprovalStage $stage)
    {
        //
    }
}
