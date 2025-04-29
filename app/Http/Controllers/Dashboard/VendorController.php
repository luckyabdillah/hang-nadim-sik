<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::orderBy('name')->get();
        return view('dashboard.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'legal_name' => 'required|max:150',
            'name' => 'required|max:150',
            'email' => 'required|email:rfc,dns|max:150',
            'address' => 'nullable|max:255',
        ]);

        Vendor::create($validatedData);

        return redirect()->route('dashboard.vendors.index')->with('success', 'Data berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('dashboard.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validatedData = $request->validate([
            'legal_name' => 'required|max:150',
            'name' => 'required|max:150',
            'email' => 'required|email:rfc,dns|max:150',
            'address' => 'nullable|max:255',
        ]);

        $vendor->update($validatedData);

        return redirect()->route('dashboard.vendors.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        Vendor::destroy($vendor->id);

        return redirect()->route('dashboard.vendors.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Display a trashed listing of the resource.
     */
    public function trashed()
    {
        $vendors = Vendor::onlyTrashed()->get();

        return view('dashboard.vendors.trashed', compact('vendors'));
    }

    /**
     * Recover the specified trashed resource in storage.
     */
    public function recover($id)
    {
        $vendor = Vendor::onlyTrashed()->findOrFail($id);
        $vendor->restore();

        return redirect()->route('dashboard.vendors.trashed')->with('success', 'Data berhasil direstore.');
    }

    /**
     * Force delete the specified trashed resource in storage.
     */
    public function forceDelete($id)
    {
        $vendor = Vendor::onlyTrashed()->findOrFail($id);
        $vendor->forceDelete();

        return redirect()->route('dashboard.vendors.trashed')->with('success', 'Data berhasil dihapus permanen.');
    }

    /**
     * Recover all trashed resource in storage.
     */
    public function recoverAll()
    {
        Vendor::onlyTrashed()->restore();

        return redirect()->route('dashboard.vendors.trashed')->with('success', 'Semua data berhasil direstore.');
    }
}
