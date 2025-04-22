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
            'name' => 'required|max:255',
            'email' => 'nullable|email:dns|max:255|unique:vendors,email',
            'address' => 'nullable|max:255',
        ]);

        Vendor::create($validatedData);

        return redirect('/dashboard/vendors')->with('success', 'Vendor created successfully');
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
        $rules = [
            'name' => 'required|max:255',
            'address' => 'nullable|max:255',
        ];

        if ($request->email != $vendor->email) {
            $rules['email'] = 'nullable|email:dns|max:255|unique:vendors,email';
        }

        $validatedData = $request->validate($rules);

        $vendor->update($validatedData);

        return redirect('/dashboard/vendors')->with('success', 'Vendor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        Vendor::destroy($vendor->id);

        return redirect('/dashboard/vendors')->with('success', 'Vendor deleted successfully');
    }
}
