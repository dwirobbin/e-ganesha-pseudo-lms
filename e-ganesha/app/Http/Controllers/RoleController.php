<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.roles.index', [
            'title' => 'Daftar Seluruh Level User',
            'roles' => Role::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('backend.roles.show', [
            'title' => "Detail Wewenang $role->name",
            'role' => $role,
            'authorities' => config('permission.authorities'),
            'rolePermissions' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('backend.roles.edit', [
            'title' => "Edit Role $role->name",
            'role' => $role,
            'authorities' => config('permission.authorities'),
            'permissionChecked' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $rules = [
            'permissions' => 'required'
        ];

        if ($request->name != $role->name) {
            $rules['name'] = 'required|unique:roles' . $role->id;
        }

        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.unique' => 'Nama sudah digunakan',
            'permissions.required' => 'Permissions wajib diisi'
        ];

        $this->validate($request, $rules, $messages);

        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        $role->save();

        activity()->log("Berhasil mengubah permissions $request->name");

        return redirect('/dashboard/admin/roles')
            ->with('success', "Berhasil mengubah data role $role->name");
    }
}
