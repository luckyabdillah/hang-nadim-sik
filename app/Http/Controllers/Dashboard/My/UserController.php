<?php

namespace App\Http\Controllers\Dashboard\My;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('applicant')->whereHas('applicant', function ($query) {
            $query->where('vendor_id', 6);
        })->get();

        return view('dashboard.my.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.my.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed',
        ]);

        $validatedData['role'] = 'applicant';

        $user = User::create($validatedData);
        Applicant::create([
            'user_id' => $user->id,
            'vendor_id' => 6,
        ]);

        return redirect()->route('dashboard.my.users.index')->with('success', 'Data berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.my.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email:rfc,dns|max:255'
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email:rfc,dns|max:255|unique:users,email';
        }

        $validatedData = $request->validate($rules);
        $user->update($validatedData);

        return redirect()->route('dashboard.my.users.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect()->route('dashboard.my.users.index')->with('success', 'Data berhasil dihapus');
    }
}
