<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WorkType;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workTypes = WorkType::orderBy('type')->get();

        return view('dashboard.work-types.index', compact('workTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.work-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|max:100',
            'unit_name' => 'required|max:100',
            'provision_text_before' => 'nullable|max:5000',
            'provision_text_after' => 'nullable|max:5000',
        ]);

        WorkType::create($validatedData);

        return redirect()->route('dashboard.work-types.index')->with('success', 'Data berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkType $workType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkType $type)
    {
        return view('dashboard.work-types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkType $type)
    {
        $validatedData = $request->validate([
            'type' => 'required|max:100',
            'unit_name' => 'required|max:100',
            'provision_text_before' => 'nullable|max:5000',
            'provision_text_after' => 'nullable|max:5000',
        ]);

        $type->update($validatedData);

        return redirect()->route('dashboard.work-types.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkType $type)
    {
        WorkType::destroy($type->id);

        return redirect()->route('dashboard.work-types.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Display a trashed listing of the resource.
     */
    public function trashed()
    {
        $workTypes = WorkType::onlyTrashed()->get();

        return view('dashboard.work-types.trashed', compact('workTypes'));
    }

    /**
     * Recover the specified trashed resource in storage.
     */
    public function recover($id)
    {
        $type = WorkType::onlyTrashed()->findOrFail($id);
        $type->restore();

        return redirect()->route('dashboard.work-types.trashed')->with('success', 'Data berhasil direstore.');
    }

    /**
     * Force delete the specified trashed resource in storage.
     */
    public function forceDelete($id)
    {
        $type = WorkType::onlyTrashed()->findOrFail($id);
        $type->forceDelete();

        return redirect()->route('dashboard.work-types.trashed')->with('success', 'Data berhasil dihapus permanen.');
    }

    /**
     * Recover all trashed resource in storage.
     */
    public function recoverAll()
    {
        WorkType::onlyTrashed()->restore();

        return redirect()->route('dashboard.work-types.trashed')->with('success', 'Semua data berhasil direstore.');
    }
}
