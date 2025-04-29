<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Applicant;
use App\Models\RegistrationRequest;

class RegistrationController extends Controller
{
    protected function findVendorIdBySimilarity($inputtedVendorName, $threshold = 70, $limit = 500)
    {
        $vendors = Vendor::latest()->limit($limit)->get();

        $normalize = function ($string) {
            return Str::of($string)
                ->lower()
                ->replaceMatches('/[^a-z0-9 ]/', ' ')
                ->replaceMatches('/\s+/', ' ')
                ->trim();
        };

        $inputtedVendorName = $normalize($inputtedVendorName);

        foreach ($vendors as $vendor) {
            $vendorLegalName = $normalize($vendor->legal_name);
            $vendorBrandName = $normalize($vendor->name);

            similar_text($inputtedVendorName, $vendorLegalName, $percent);
            similar_text($inputtedVendorName, $vendorBrandName, $percent2);

            if ($percent >= $threshold || $percent2 >= $threshold) {
                return $vendor->id;
            }
        }

        return null;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = RegistrationRequest::latest()->get();
        return view('dashboard.registrations.index', compact('registrations'));
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
    public function show(RegistrationRequest $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistrationRequest $registration)
    {
        $vendors = Vendor::orderBy('name')->get();
        $vendorPossibility = $this->findVendorIdBySimilarity($registration->vendor_name);

        return view('dashboard.registrations.edit', compact('registration', 'vendors', 'vendorPossibility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistrationRequest $registration)
    {
        $validatedData = $request->validate([
            'vendor_id' => 'required|numeric',
        ]);

        $user = User::create([
            'name' => $registration->name,
            'email' => $registration->email,
            'password' => $registration->password,
            'role' => 'applicant',
        ]);

        Applicant::create([
            'user_id' => $user->id,
            'vendor_id' => $validatedData['vendor_id'],
        ]);

        RegistrationRequest::destroy($registration->id);

        return redirect()->route('dashboard.registrations.index')->with('success', 'Registrasi berhasil disetujui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistrationRequest $registration)
    {
        //
    }
}
