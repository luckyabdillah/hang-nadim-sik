<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('title')->get();

        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');

        return view('dashboard.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'permissions' => 'nullable',
        ]);

        $role = Role::create(['title' => $validatedData['title']]);
        $syncPermissions = $request->permissions ? $validatedData['permissions'] : [];
        $role->permissions()->sync($syncPermissions);

        return redirect('/dashboard/user-management/roles')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');
        $currentPermissions = $role->permissions->pluck('id')->toArray();
        
        return view('dashboard.roles.edit', compact('role', 'permissions', 'currentPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'permissions' => 'nullable'
        ]);

        $role->update(['title' => $validatedData['title']]);
        $syncPermissions = $request->permissions ? $validatedData['permissions'] : [];
        $role->permissions()->sync($syncPermissions);

        return redirect('/dashboard/user-management/roles')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $relatedUsers = User::where('role_id', $role->id)->get();
        foreach ($relatedUsers as $user) {
            $user->update(['role_id' => null]);
        }

        Role::destroy($role->id);

        return redirect('/dashboard/user-management/roles')->with('success', 'Data berhasil dihapus');
    }
}
