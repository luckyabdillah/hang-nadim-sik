<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\User;
use Illuminate\Http\Request;

class ApproverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvers = Approver::with('user')->orderBy('level')->get();

        return view('dashboard.approvers.index', compact('approvers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.approvers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['is_default_approver'] = isset($request->is_default_approver) ? true : false;
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email:dns|unique:users,email',
            'position' => 'required|max:255',
            'level' => 'required|numeric|min:1|max:100',
            'signature' => 'nullable|image',
            'password' => 'required|min:8|max:255|confirmed',
            'is_default_approver' => 'nullable',
        ]);

        if ($request->file('signature')) {
            $validatedData['signature'] = $request->file('signature')->store('signature');
        } else {
            $validatedData['signature'] = null;
        }

        $validatedDataUser = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'role' => 'approver',
        ];

        $user = User::create($validatedDataUser);

        $validatedDataApprover = [
            'user_id' => $user->id,
            'position' => $validatedData['position'],
            'level' => $validatedData['level'],
            'signature' => $validatedData['signature'],
            'is_default_approver' => $validatedData['is_default_approver'],
        ];

        Approver::create($validatedDataApprover);

        return redirect()->route('dashboard.approvers.index')->with('success', 'Data berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Approver $approver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Approver $approver)
    {
        return view('dashboard.approvers.edit', compact('approver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Approver $approver)
    {
        $request['is_default_approver'] = isset($request->is_default_approver) ? true : false;
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email:dns',
            'position' => 'required|max:255',
            'level' => 'required|numeric|min:1|max:100',
            'is_default_approver' => 'nullable',
        ];

        if ($request->email != $approver->user->email) {
            $rules['email'] = 'required|max:255|email:dns|unique:users,email';
        }

        $validatedData = $request->validate($rules);

        $validatedDataUser = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ];

        User::where('id', $approver->user_id)->update($validatedDataUser);

        $validatedDataApprover = [
            'position' => $validatedData['position'],
            'level' => $validatedData['level'],
            'is_default_approver' => $validatedData['is_default_approver'],
        ];

        $approver->update($validatedDataApprover);

        return redirect()->route('dashboard.approvers.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Approver $approver)
    {
        User::destroy($approver->user_id);
        Approver::destroy($approver->id);

        return redirect()->route('dashboard.approvers.index')->with('success', 'Data berhasil dihapus');
    }
}
