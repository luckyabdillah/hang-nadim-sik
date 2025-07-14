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
        // $users = User::where('user_type', 'internal')
        //                 ->whereNotIn('id', function ($query) {
        //                     $query->select('user_id')->from('approvers');
        //                 })->get();

        $users = User::where('user_type', 'internal')->whereDoesntHave('approver')->get();

        return view('dashboard.approvers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['is_default_approver'] = isset($request->is_default_approver) ? true : false;
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id|unique:approvers,user_id',
            'position' => 'required|max:255',
            'level' => 'required|numeric|min:1|max:100',
            'signature' => 'required|image',
            'is_default_approver' => 'nullable',
        ]);

        $validatedData['signature'] = $request->file('signature')->store('signatures');

        Approver::create($validatedData);

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
        $validatedData = $request->validate([
            'position' => 'required|max:255',
            'level' => 'required|numeric|min:1|max:100',
            'signature' => 'nullable|image',
            'is_default_approver' => 'nullable',
        ]);

        if ($request->file('signature')) {
            $validatedData['signature'] = $request->file('signature')->store('signatures');
        } else {
            $validatedData['signature'] = null;
        }

        $approver->update($validatedData);

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
