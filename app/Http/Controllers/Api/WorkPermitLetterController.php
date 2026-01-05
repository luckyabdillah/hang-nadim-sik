<?php

namespace App\Http\Controllers\Api;

use Mail;
use Exception;
use Carbon\Carbon;
use App\Models\Approver;
use App\Models\WorkLocation;
use Illuminate\Http\Request;
use App\Mail\SubmittedLetter;
use App\Models\ApprovalStage;
use App\Mail\ApprovalStageMail;
use App\Mail\RejectedLetterMail;
use App\Models\WorkPermitLetter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WorkPermitLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestedDateRange = request('date');
        if ($requestedDateRange) {
            [$dateRangeStart, $dateRangeEnd] = explode(' - ', $requestedDateRange);
        } else {
            $dateRangeStart = date('01/m/Y');
            $dateRangeEnd = date('d/m/Y');
        }

        $start = Carbon::createFromFormat('d/m/Y', $dateRangeStart)->startOfDay();
        $end = Carbon::createFromFormat('d/m/Y', $dateRangeEnd)->endOfDay();
        
        $letters = WorkPermitLetter::with([
            'vendor' => function ($query) {
                $query->withTrashed();
            },
            'workType' => function ($query) {
                $query->withTrashed();
            },
        ])->whereBetween('created_at', [$start, $end]);

        if (request('search')) {
            $letters = $letters->where('letter_number', 'like', '%' . request('search') . '%')->orWhereHas('vendor', function ($query) {
                $query->where('legal_name', 'like', '%' . request('search') . '%')->orWhereHas('user', function ($query) {
                    $query->where('name',  'like', '%' . request('search') . '%');
                });
            });
        }
        
        $letters = $letters->latest()->paginate(10)->withQueryString();

        if (!$letters) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'No data available',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $letters,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'vendor_id' => 'required|exists:vendors,id',
                'work_location_id' => 'required',
                'other_location' => 'nullable|max:100',
                'work_type_id' => 'required|numeric|exists:work_types,id',
                'started_at' => 'required|date|after_or_equal:today',
                'ended_at' => 'required|date',
                'description' => 'required|max:255',
                'external_pic_name' => 'required|max:150',
                'external_pic_number' => 'required|numeric|max_digits:12',
                'application_letter' => 'required|file|mimes:pdf|max:4096',
                'application_letter_number' => 'required|max:50',
                'application_letter_date' => 'required|date',
                'airport_pass' => 'nullable|file|mimes:pdf|max:4096',
                'job_safety_analysis_document' => 'nullable|file|mimes:pdf|max:4096',
            ];

            if ($request->input('work_location_id') === 'lainnya') {
                $rules['other_location'] = 'required|max:100';
            } else {
                $rules['work_location_id'] = 'required|numeric|exists:work_locations,id';
            }

            $startDate = Carbon::parse($request->input('started_at'));
            $endDate = Carbon::parse($request->input('ended_at'));
            $diffInDays = $startDate->diffInDays($endDate);

            if ($diffInDays >= 3) {
                $rules['airport_pass'] = 'required|file|mimes:pdf|max:4096';
            }
            
            $validatedData = $request->validate($rules);

            Carbon::setLocale('id');
            $applicationLetterDate = Carbon::parse($validatedData['application_letter_date']);

            $workLocation = WorkLocation::firstWhere('id', $validatedData['work_location_id']);
            if ($workLocation) {
                $validatedData['work_location'] = $workLocation->location;
                if ($workLocation->description) {
                    $validatedData['work_location'] .= " ($workLocation->description)";
                }
            } else {
                $validatedData['work_location'] = $validatedData['other_location'];
            }
    
            $validatedData['external_pic_number'] = '+62' . $validatedData['external_pic_number'];
            $validatedData['pointing'] = "Surat HR. Dept. " . auth()->user()->name . " Nomor: " . $validatedData['application_letter_number'] . " tanggal " . $applicationLetterDate->translatedFormat('d F Y') . " perihal Izin " . $validatedData['description'];
    
            $validatedData['application_letter'] = $request->file('application_letter')->store('application_letters');
            if ($request->file('airport_pass')) {
                $validatedData['airport_pass'] = $request->file('airport_pass')->store('airport_passes');
            }
            if ($request->file('job_safety_analysis_document')) {
                $validatedData['job_safety_analysis_document'] = $request->file('job_safety_analysis_document')->store('jsa_documents');
            }
    
            $letter = WorkPermitLetter::create($validatedData);
            $mailInfo = 'khrsmn123@gmail.com';
            $mailDelivery = false;
            $mailAttemps = 0;
            while (!$mailDelivery) {
                if ($mailAttemps >= 3) {
                    break;
                }
                try {
                    Mail::to($mailInfo)
                        ->send(new SubmittedLetter($letter));
                    
                    $mailDelivery = true;
                } catch (\Throwable $th) {
                    $mailAttemps += 1;
                }
            }

            if (!$mailDelivery) {
                throw new Exception("An error occurred when sending email notification");
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
            'data' => $letter,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        try {
            $letter = WorkPermitLetter::findOrFail($uuid);

            return response()->json([
                'statusCode' => 200,
                'message' => 'OK',
                'data' => $letter
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Resource not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'approvers' => 'required',
                'letter_number' => 'required|max:150',
                'letter_number_end' => 'required|max:10|alpha',
                'pointing' => 'nullable|max:1000',
                'internal_pic_name' => 'required|max:150',
                'internal_pic_number' => 'required|numeric|max_digits:12',
            ]);
    
            $letter = WorkPermitLetter::findOrFail($uuid);
            $validatedData['letter_number'] = 'BTH.' . $validatedData['letter_number'] . '/SIK/BIB/' . date('Y') . '-' . $validatedData['letter_number_end'];
            $validatedData['status'] = 'verified';
            $letter->update($validatedData);
            
            $approvers = Approver::with('user')
                            ->whereIn('id', $validatedData['approvers'])
                            ->orderBy('level')
                            ->get()
                            ->keyBy('id');

            foreach ($validatedData['approvers'] as $approverId) {
                $approver = $approvers->get($approverId);
                if (!$approver->signature) {
                    throw new Exception("Tanda tangan $approver->position belum ada. Mohon lengkapi terlebih dahulu");
                }

                $stage = ApprovalStage::create([
                    'work_permit_letter_id' => $letter->id,
                    'approver_id' => $approver->id,
                    'email' => $approver->user->email,
                    'name' => $approver->user->name,
                    'position' => $approver->position,
                    'level' => $approver->level,
                    'signature' => $approver->signature,
                ]);
    
                // Send email to first approver
                if ($approver->id == $approvers->first()->id) {
                    $stage->update(['status' => 'waiting']);
                    $mailDelivery = false;
                    $mailAttemps = 0;
                    while (!$mailDelivery) {
                        if ($mailAttemps >= 3) {
                            break;
                        }
                        try {
                            Mail::to($approver->user->email)
                                ->send(new ApprovalStageMail($letter, $stage));
                            
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

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 404,
                'message' => 'Resource not found'
            ], 404);
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
            'data' => $letter,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $uuid)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'notes' => 'required|max:255',
            ]);
            $validatedData['status'] = 'rejected';
    
            $letter = WorkPermitLetter::findOrFail($uuid);
            
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
    
            $letter->update($validatedData);

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 404,
                'message' => 'Resource not found'
            ], 404);
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
            'data' => null,
        ], 200);
    }
}
