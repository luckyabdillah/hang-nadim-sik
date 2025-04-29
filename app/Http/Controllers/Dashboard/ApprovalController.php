<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ApprovalStage;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

use Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ApprovalStageMail;
use Exception;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = ApprovalStage::with([
            'workPermitLetter.vendor',
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
        if ($stage->status == 'pending') return redirect()->route('dashboard.approvals.index')->with('failed', 'Tidak dapat memproses tahapan yang masih pending');

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

        try {
            DB::beginTransaction();

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
    
                $oneStageAfter = ApprovalStage::with(['workPermitLetter', 'approver.user'])->where('work_permit_letter_id', $stage->workPermitLetter->id)->where('level', '>', $stage->level)->orderBy('level')->first();
                if ($oneStageAfter) {
                    $approvalStepCompletion = false;
                    $oneStageAfter->update(['status' => 'waiting']);
                    $stage->workPermitLetter->update(['status' => 'verified']);
                    
                    $mailDelivery = false;
                    $mailAttemps = 0;
                    while (!$mailDelivery) {
                        if ($mailAttemps >= 3) {
                            break;
                        }
                        try {
                            Mail::to($oneStageAfter->approver->user->email)
                                ->send(new ApprovalStageMail($oneStageAfter->workPermitLetter, $oneStageAfter));
                            
                            $mailDelivery = true;
                        } catch (\Throwable $th) {
                            $mailAttemps += 1;
                        }
                    }
        
                    if (!$mailDelivery) {
                        throw new Exception("An error occurred when sending email notification");
                    }
                }
            }

            if ($approvalStepCompletion) {
                // Generate QR Code
                $link = config('app.url') . '/dashboard/my/work-permit-letters/' . $stage->workPermitLetter->uuid;
                $qr = QrCode::format('png')->size(200)->generate($link);
                $qrImageName = 'qr_codes/' . str_replace('/', '-', $stage->workPermitLetter->letter_number) . '.png';

                // Save QR Code to Storage and Letter instance
                Storage::put($qrImageName, $qr);
                $stage->workPermitLetter->update(['qr_code' => $qrImageName]);

                // Send mail to vendor
                // $mailDelivery = false;
                // $mailAttemps = 0;
                // while (!$mailDelivery) {
                //     if ($mailAttemps >= 3) {
                //         break;
                //     }
                //     try {
                //         Mail::to($stage->workPermitLetter->vendor->email)
                //             ->send(new ApprovedMail($oneStageAfter->workPermitLetter));
                        
                //         $mailDelivery = true;
                //     } catch (\Throwable $th) {
                //         $mailAttemps += 1;
                //     }
                // }
    
                // if (!$mailDelivery) {
                //     throw new Exception("An error occurred when sending email notification");
                // }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.approvals.show', ['stage' => $stage->id])->withInput()->with('failed', $th->getMessage());
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
