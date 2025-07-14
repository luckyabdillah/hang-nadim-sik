<?php

namespace App\Http\Controllers\Dashboard;

use Mail;
use Exception;
use Carbon\Carbon;
use App\Models\Copy;
use App\Models\Approver;
use Illuminate\Http\Request;
use App\Models\ApprovalStage;
use App\Mail\ApprovalStageMail;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\RejectedLetterMail;
use App\Models\WorkPermitLetter;
use App\Models\LetterFundamental;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Exports\WorkPermitLetterExport;
use Maatwebsite\Excel\Facades\Excel;

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

        return view('dashboard.work-permit-letters.index', compact('letters', 'dateRangeStart', 'dateRangeEnd'));
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
        ]);

        $currentMonth = date('Y-m');
        
        $approvers = Approver::orderBy('level')->get();
        $stages = ApprovalStage::where('work_permit_letter_id', $letter->id)->orderBy('level')->get();
        $totalLettersCurrentMonth = WorkPermitLetter::where('created_at', 'like', "$currentMonth%")->count();
        $newLetterNumber = str_pad($totalLettersCurrentMonth + 1, 3, '0', STR_PAD_LEFT);

        $letterMonth = date('m', strtotime($letter->ended_at));
        $monthsInAlphaList = [
            '01' => 'A',
            '02' => 'B',
            '03' => 'C',
            '04' => 'D',
            '05' => 'E',
            '06' => 'F',
            '07' => 'G',
            '08' => 'H',
            '09' => 'I',
            '10' => 'J',
            '11' => 'K',
            '12' => 'L',
        ];

        $monthInAlpha = $monthsInAlphaList[$letterMonth];

        return view('dashboard.work-permit-letters.show', compact('letter', 'approvers', 'stages', 'newLetterNumber', 'monthInAlpha'));
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
            'letter_number' => 'required|max:150',
            'letter_number_end' => 'required|max:10|alpha',
            'pointing' => 'nullable|max:1000',
            'internal_pic_name' => 'required|max:150',
            'internal_pic_number' => 'required|numeric|max_digits:12',
        ]);

        $validatedData['letter_number'] = 'BTH.' . $validatedData['letter_number'] . '/SIK/BIB/' . date('Y') . '-' . $validatedData['letter_number_end'];

        try {
            DB::beginTransaction();

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
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.work-permit-letters.show', ['letter' => $letter->uuid])->withInput()->with('failed', $th->getMessage());
        }

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
        
        try {
            DB::beginTransaction();
            
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
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.work-permit-letters.show', ['letter' => $letter->uuid])->withInput()->with('failed', $th->getMessage());
        }
    
        return redirect()->route('dashboard.work-permit-letters.show', ['letter' => $letter->uuid])->with('success', 'SIK berhasil ditolak');
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportPDF(WorkPermitLetter $letter)
    {
        if ($letter->status != 'approved') return redirect()->route('dashboard.work-permit-letters.show', ['letter' => $letter->uuid])->with('failed', 'Tidak dapat mendownload SIK yang belum disetujui');
        
        $letter->load([
            'vendor' => function ($query) {
                $query->withTrashed();
            },
            'workType' => function ($query) {
                $query->withTrashed();
            },
        ]);
        
        $fundamentals = LetterFundamental::orderBy('position')->get();
        $copies = Copy::all();

        Carbon::setLocale('id');

        $issuedDate = Carbon::parse($letter->updated_at);
        $startDate = Carbon::parse($letter->started_at);
        $endDate = Carbon::parse($letter->ended_at);

        $workDate = $startDate->translatedFormat('d F Y') . ' – ' . $endDate->translatedFormat('d F Y');

        $pdf = Pdf::loadView('dashboard.work-permit-letters.export-pdf', compact('letter', 'fundamentals', 'copies', 'issuedDate', 'workDate'));

        $dompdf = $pdf->getDomPDF();
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->get_font('serif', 'normal');

        // $canvas->page_text(270, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, [0,0,0]);
        $canvas->page_text(135, 798, "Jl. Hang Nadim No. 01, Batu Besar, Nongsa, Kota Batam, Kepulauan Riau, 29466", $font, 10, [0.5, 0.5, 0.5]);
        $canvas->page_text(260, 813, "www.bthairport.com", $font, 10, [0.5, 0.5, 0.5]);
        
        return $pdf->stream(str_replace('/', '-', $letter->letter_number) . '.pdf');
    }

    /**
     * Export the specified listing resource to Excel.
     */
    public function exportExcel()
    {
        $requestedDateRange = request('date');
        if ($requestedDateRange) {
            [$dateRangeStart, $dateRangeEnd] = explode(' - ', $requestedDateRange);
        } else {
            $dateRangeStart = date('01/m/Y');
            $dateRangeEnd = date('d/m/Y');
        }

        Carbon::setLocale('id');
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
        
        $letters = $letters->get();
        $period = $start->translatedFormat('d F Y') . ' - ' . $end->translatedFormat('d F Y');
        $appName = strtoupper(config('app.name'));

        return Excel::download(new WorkPermitLetterExport($letters, $period), 'LAPORAN_SURAT_IZIN_KERJA_' . str_replace(' ', '_', $appName) . '_' . str_replace(' ', '_', $period) . '.xlsx');
    }

    /**
     * Completion update the specified resource in storage.
     */
    public function updateCompletion(Request $request, WorkPermitLetter $letter)
    {
        $validatedData = $request->validate([
            'photo' => 'required|image',
        ]);

        $validatedData['status'] = 'finished';
        $validatedData['photo'] = $request->file('photo')->store('completion_photos');
        $letter->update($validatedData);

        return redirect()->route('dashboard.work-permit-letters.show', ['letter' => $letter->uuid])->with('success', 'SIK berhasil diperbarui');
    }
}
