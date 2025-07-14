<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = auth()->user();
        
        return view('dashboard.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email:rfc,dns|unique:registration_requests,email',
        ];

        if ($user->email != $request->email) {
            $rules['email'] = 'required|max:255|email:rfc,dns|unique:users,email|unique:registration_requests,email';
        }

        $validatedData = $request->validate($rules);

        $user->update($validatedData);

        return redirect('/dashboard/profile')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Update the user's approver information.
     */
    public function updateApprover(Request $request)
    {
        $user = auth()->user();

        if (!$user->approver) return redirect()->back()->with('failed', 'Akun bukan approver');

        $validatedData = $request->validate([
            'signature' => 'required|image',
        ]);

        $validatedData['signature'] = $request->file('signature')->store('signatures');
        $user->approver->update($validatedData);

        return redirect('/dashboard/profile')->with('success', 'Data berhasil diperbarui');
    }
}
