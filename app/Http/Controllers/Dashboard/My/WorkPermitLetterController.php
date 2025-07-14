<?php

namespace App\Http\Controllers\Dashboard\My;

use Mail;
use Exception;
use App\Http\Controllers\Controller;
use App\Mail\SubmittedLetter;
use App\Models\WorkLocation;
use App\Models\WorkPermitLetter;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WorkPermitLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = auth()->user()->vendor;
        $letters = WorkPermitLetter::with([
            'vendor' => function ($query) {
                $query->withTrashed();
            },
            'workType' => function ($query) {
                $query->withTrashed();
            },
        ])->where('vendor_id', $vendor->id)->latest()->paginate(10);

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
        try {
            DB::beginTransaction();
            $vendor = auth()->user()->vendor;
            $rules = [
                'date_diff' => 'required|numeric',
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
    
            $validatedData['vendor_id'] = $vendor->id;
            $validatedData['application_letter'] = $request->file('application_letter')->store('application_letters');
            if ($request->file('airport_pass')) {
                $validatedData['airport_pass'] = $request->file('airport_pass')->store('airport_passes');
            }
            if ($request->file('job_safety_analysis_document')) {
                $validatedData['job_safety_analysis_document'] = $request->file('job_safety_analysis_document')->store('jsa_documents');
            }
    
            $letter = WorkPermitLetter::create($validatedData);
            $mailInfo = 'info@bthairport.com';
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
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/dashboard/my/work-permit-letters')->with('failed', $th->getMessage());
        }

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
