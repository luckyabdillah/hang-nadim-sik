<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email:dns|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed',
            'role' => 'required|in:admin,applicant,verificator,approver,avsec,superuser',
        ]);

        User::create($validatedData);

        return redirect('/dashboard/users')->with('success', 'User created successfully');
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
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'role' => 'required|in:admin,applicant,verificator,approver,avsec,superuser',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'nullable|email:dns|max:255|unique:users,email';
        }

        $validatedData = $request->validate($rules);

        $user->update($validatedData);

        return redirect('/dashboard/users')->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/dashboard/users')->with('success', 'User deleted successfully');
    }
}
