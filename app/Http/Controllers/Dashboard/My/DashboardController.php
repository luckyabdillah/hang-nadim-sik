<?php

namespace App\Http\Controllers\Dashboard\My;

use App\Http\Controllers\Controller;
use App\Models\WorkPermitLetter;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('dashboard.my.index');
        $vendor = auth()->user()->vendor;
        $currentMonth = date('Y-m');
        $currentDate = date('Y-m-d');

        $months = collect([
            Carbon::now()->subMonths(2)->format('Y-m'),
            Carbon::now()->subMonths(1)->format('Y-m'),
            Carbon::now()->format('Y-m'),
        ]);
        
        $rawData = DB::table('work_permit_letters')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->where('vendor_id', $vendor->id)
            ->where('created_at', '>=', Carbon::now()->subMonths(2)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');
        
        $lettersPerMonth = $months->map(function ($month) use ($rawData) {
            return [
                'month' => date('M', strtotime("$month-01")),
                'total' => $rawData[$month]->total ?? 0
            ];
        });

        $getWorkPermitLetters = WorkPermitLetter::with(['vendor', 'workType'])->where('created_at', 'like', "$currentMonth%")->where('vendor_id', $vendor->id);

        $allWorkPermitLetters = WorkPermitLetter::where('vendor_id', $vendor->id)->count();
        $workPermitLetters = (clone $getWorkPermitLetters)->get();
        $activeWorkPermitLetters = (clone $getWorkPermitLetters)->where('status', 'approved')->where('ended_at', '>=', $currentDate)->get();
        $finishedWorkPermitLetters = (clone $getWorkPermitLetters)->where('status', 'finished')->get();
        $expiredWorkPermitLetters = (clone $getWorkPermitLetters)->where('status', 'approved')->where('ended_at', '<', $currentDate)->get();
        $pendingWorkPermitLetters = (clone $getWorkPermitLetters)->whereIn('status', ['submitted', 'verified'])->get();
        $expireTodayWorkPermitLetters = (clone $getWorkPermitLetters)->where('status', 'approved')->where('ended_at', '=', $currentDate)->get();
        
        return view('dashboard.my.index', compact('allWorkPermitLetters', 'workPermitLetters', 'activeWorkPermitLetters', 'finishedWorkPermitLetters', 'expiredWorkPermitLetters', 'pendingWorkPermitLetters', 'expireTodayWorkPermitLetters', 'lettersPerMonth'));
    }
}
