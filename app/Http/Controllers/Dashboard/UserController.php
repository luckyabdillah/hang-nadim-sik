<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->where('user_type', 'internal')->orderBy('name')->get();

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'role_id' => 'required|numeric',
            'email' => 'required|max:255|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed',
        ]);

        $validatedData['user_type'] = 'internal';

        User::create($validatedData);

        return redirect()->route('dashboard.users.index')->with('success', 'Data berhasil dibuat');
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
        $roles = Role::all();

        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'role_id' => 'required|numeric',
            'email' => 'required|email:rfc,dns|max:255'
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'nullable|email:rfc,dns|max:255|unique:users,email';
        }

        $validatedData = $request->validate($rules);

        $user->update($validatedData);

        return redirect()->route('dashboard.users.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect()->route('dashboard.users.index')->with('success', 'Data berhasil dihapus');
    }
}
