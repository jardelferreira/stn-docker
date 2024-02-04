<?php

namespace App\Http\Controllers;

use Yajra\Acl\Models\Role;
use Illuminate\Http\Request;
use Yajra\Acl\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware("permission:admin,acl");
    }
    public function index()
    {
        return \view('dashboard/roles.index',[
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard/roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create($request->all());

        return redirect()->route('dashboard.roles',[
            'roles' => Role::all()
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // dd($role->getPermissions());
        return \view('dashboard/roles.show',[
            'role' => $role
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $role = Role::where('id',$request->id)->first();

        return view('dashboard/roles.edit',[
            'role' => $role
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
        $role = Role::where('id',$request->id)->first();

        $role->update($request->all());

        return redirect()->route('dashboard.roles',[
            'roles' =>  Role::all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = Role::where('id',$request->id)->first();

        $role->delete();

        return redirect()->route('dashboard.roles',[
            'roles' => Role::all()
        ]);
    }

    public function permissions(Role $role)
    {
        //    dd($role->permissions()->pluck("permission_id"));
        return view('dashboard/roles.permissions',[
            'role' => $role,
            'permissions' => Permission::get()->chunk(4),
            'role_permissions' => $role->permissions()->pluck("permission_id")->toArray()
        ]);
    }

    public function syncPermissionsById(Role $role, Request $request)
    {
        $role->syncPermissions($request->permissions);

        return redirect()->route('dashboard.roles.permissions',$role);

    }
}
