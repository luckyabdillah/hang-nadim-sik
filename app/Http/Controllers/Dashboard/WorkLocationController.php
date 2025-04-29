<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WorkLocation;
use Illuminate\Http\Request;

class WorkLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workLocations = WorkLocation::orderBy('location')->get();

        return view('dashboard.work-locations.index', compact('workLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.work-locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'location' => 'required|max:100',
            'description' => 'required|max:255',
        ]);

        WorkLocation::create($validatedData);

        return redirect()->route('dashboard.work-locations.index')->with('success', 'Data berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkLocation $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkLocation $location)
    {
        return view('dashboard.work-locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkLocation $location)
    {
        $validatedData = $request->validate([
            'location' => 'required|max:100',
            'description' => 'required|max:255',
        ]);

        $location->update($validatedData);

        return redirect()->route('dashboard.work-locations.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLocation $location)
    {
        WorkLocation::destroy($location->id);

        return redirect()->route('dashboard.work-locations.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Display a trashed listing of the resource.
     */
    public function trashed()
    {
        $workLocations = WorkLocation::onlyTrashed()->get();

        return view('dashboard.work-locations.trashed', compact('workLocations'));
    }

    /**
     * Recover the specified trashed resource in storage.
     */
    public function recover($id)
    {
        $location = WorkLocation::onlyTrashed()->findOrFail($id);
        $location->restore();

        return redirect()->route('dashboard.work-locations.trashed')->with('success', 'Data berhasil direstore.');
    }

    /**
     * Force delete the specified trashed resource in storage.
     */
    public function forceDelete($id)
    {
        $location = WorkLocation::onlyTrashed()->findOrFail($id);
        $location->forceDelete();

        return redirect()->route('dashboard.work-locations.trashed')->with('success', 'Data berhasil dihapus permanen.');
    }

    /**
     * Recover all trashed resource in storage.
     */
    public function recoverAll()
    {
        WorkLocation::onlyTrashed()->restore();

        return redirect()->route('dashboard.work-locations.trashed')->with('success', 'Semua data berhasil direstore.');
    }
}
