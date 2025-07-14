<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('group')->orderBy('name')->get();

        return view('dashboard.permissions.index', compact('permissions'));
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
        $request['name'] = strtolower(trim($request['name']));
        $request['name'] = str_replace(' ', '_', $request['name']);

        $validatedData = $request->validate([
            'name' => 'required|unique:permissions,name',
            'group' => 'required',
        ]);

        Permission::create($validatedData);

        return redirect('/dashboard/user-management/permissions')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request['name'] = strtolower(trim($request['name']));
        $request['name'] = str_replace(' ', '_', $request['name']);

        $rules = [
            'group' => 'required',
        ];

        if ($request->name != $permission->name) {
            $rules['name'] = 'required|unique:permissions,name';
        }

        $validatedData = $request->validate($rules);

        $permission->update($validatedData);

        return redirect('/dashboard/user-management/permissions')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        Permission::destroy($permission->id);

        return redirect('/dashboard/user-management/permissions')->with('success', 'Data berhasil dihapus');
    }
}
