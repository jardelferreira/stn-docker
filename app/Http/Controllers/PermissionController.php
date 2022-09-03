<?php

namespace App\Http\Controllers;

use Yajra\Acl\Models\Role;
use Illuminate\Http\Request;
use Yajra\Acl\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('dashboard.permissions.index',[
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('dashboard.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create($request->all());

        return \redirect()->route('dashboard.permissions',[
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $permission = Permission::where('id',$id)->first();

        return view('dashboard.permissions.show',[
            'permission' => $permission
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $permission = Permission::where('id',$id)->first();

        return view('dashboard.permissions.edit',[
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
        $permission = Permission::where('id',$request->id)->first();
        // dd($permission);
        $permission->update($request->all());
        
        return \redirect()->route('dashboard.permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $permission = Permission::where('id',$request->id)->first();

        $permission->delete();

        return \redirect()->route('dashboard.permissions',[
            'permissions' => Permission::all()
        ]);
    }

    public function roles(Permission $permission)
    {
        return view('dashboard/permissions.roles',[
            'permission' => $permission,
            'roles' => Role::all(),
            'permission_roles' => $permission->roles()->pluck('role_id')->toArray()
        ]);
    }

    public function syncRolesById(Permission $permission, Request $request)
    {
        // dd($permission->roles()->pluck('role_id')->toArray());
        $permission->syncRoles($request->roles);

        return redirect()->route('dashboard.permissions.roles',[
            'permission' => $permission,
            'roles' => Role::all(),
            'permission_roles' => $permission->roles()->pluck('role_id')->toArray()
        ]);
    }
}
