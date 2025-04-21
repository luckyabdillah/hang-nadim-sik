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
            'location' => 'required|max:150',
        ]);

        WorkLocation::create($validatedData);

        return redirect('/dashboard/work-locations')->with('success', 'Work location created successfully');
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
            'location' => 'required|max:150',
        ]);

        $location->update($validatedData);

        return redirect('/dashboard/work-locations')->with('success', 'Work location updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLocation $location)
    {
        WorkLocation::destroy($location->id);

        return redirect('/dashboard/work-locations')->with('success', 'Work location deleted successfully');
    }
}
