<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ApprovalStageMail;
use App\Mail\ApprovedLetterMail;
use App\Mail\RejectedLetterMail;
use App\Models\ApprovalStage;
use App\Models\Copy;
use App\Models\WorkPermitLetter;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $requestedDateRange = request('date');
            if ($requestedDateRange) {
                [$dateRangeStart, $dateRangeEnd] = explode(' - ', $requestedDateRange);
            } else {
                $dateRangeStart = date('01/m/Y');
                $dateRangeEnd = date('d/m/Y');
            }
        
            $start = Carbon::createFromFormat('d/m/Y', $dateRangeStart)->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $dateRangeEnd)->endOfDay();
            
            $stages = ApprovalStage::with([
                'workPermitLetter.vendor' => function ($query) {
                    $query->withTrashed();
                },
            ])->whereBetween('created_at', [$start, $end]);
        
            // if (auth()->user()->role->title != 'Super User') {
            //     $approverId = Auth::user()->approver?->id;
            //     $stages = $stages->where('approver_id', $approverId);
            // }
        
            if (request('search')) {
                $stages = $stages->whereHas('workPermitLetter', function ($query) {
                    $query->where('letter_number', 'like', '%' . request('search') . '%')->orWhereHas('vendor', function ($query) {
                        $query->where('legal_name', 'like', '%' . request('search') . '%')->orWhereHas('user', function ($query) {
                            $query->where('name',  'like', '%' . request('search') . '%');
                        });
                    });
                });
            }
        
            $stages = $stages->latest()->paginate(10)->withQueryString();
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $stages,
        ], 200);
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
        try {
            $stage = ApprovalStage::findOrFail($id);
            if ($stage->status == 'pending') throw new Exception("Tidak dapat memproses tahapan yang masih pending");

            $stage->load([
                'workPermitLetter' => function ($query) {
                    $query->with([
                        'vendor' => function ($query) {
                            $query->withTrashed();
                        },
                        'workType' => function ($query) {
                            $query->withTrashed();
                        },
                    ]);
                },
            ]);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
            
        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $stage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'status' => 'required|in:approved,rejected',
                'notes' => 'required_if:status,rejected|max:500'
            ];

            $validatedData = $request->validate($rules);

            $stage = ApprovalStage::findOrFail($id);
            $stage->update($validatedData);
            $stage->workPermitLetter->update([
                'status' => $stage->status,
                'notes' => $stage->notes,
            ]);

            $letter = WorkPermitLetter::with('vendor')->where('id', $stage->work_permit_letter_id)->first();
            
            $approvalStepCompletion = false;
            if ($request->status == 'approved') {
                $stage->update(['notes' => null]);
                $stage->workPermitLetter->update(['notes' => null]);
                $approvalStepCompletion = true;
    
                $oneStageAfter = ApprovalStage::with(['workPermitLetter', 'approver.user'])->where('id', '!=', $stage->id)->where('work_permit_letter_id', $stage->workPermitLetter->id)->where('level', '>=', $stage->level)->orderBy('level')->first();
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
            } else {
                $allApprovalStages = ApprovalStage::where('id', $stage->work_permit_letter_id)->get();
                foreach ($allApprovalStages as $approvalStage) {
                    $approvalStage->update(['status' => 'rejected']);
                }
                
                $mailDelivery = false;
                $mailAttemps = 0;
                while (!$mailDelivery) {
                    if ($mailAttemps >= 3) {
                        break;
                    }
                    try {
                        Mail::to($letter->vendor->email)
                            ->send(new RejectedLetterMail($letter));
                        
                        $mailDelivery = true;
                    } catch (\Throwable $th) {
                        $mailAttemps += 1;
                    }
                }
    
                if (!$mailDelivery) {
                    throw new Exception("An error occurred when sending email notification");
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

                $copies = Copy::where('send_email', 1)->pluck('email');

                // Send mail to vendor
                $mailDelivery = false;
                $mailAttemps = 0;
                while (!$mailDelivery) {
                    if ($mailAttemps >= 3) {
                        break;
                    }
                    try {
                        Mail::to($letter->vendor->user->email)
                            ->cc($copies)
                            ->send(new ApprovedLetterMail($letter));
                        
                        $mailDelivery = true;
                    } catch (\Throwable $th) {
                        $mailAttemps += 1;
                    }
                }
    
                if (!$mailDelivery) {
                    throw new Exception("An error occurred when sending email notification");
                }
            }

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => [
                'stage' => $stage,
                'work-permit-letter' => $letter,
            ],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
