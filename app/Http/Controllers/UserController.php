<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Signature;
use App\Models\User;
use Yajra\Acl\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\Acl\Models\Permission;

class UserController extends Controller
{

    public function __construct()
    {
        // $this->middleware('manager-user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('dashboard/users.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('dashboard/users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, User $user)
    {
        $user->create($request->all());

        return redirect()->route('dashboard.users', [
            'users' => User::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {     
        // $user->generateSignature('teste');
        return view('dashboard/users/show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        return view(
            'dashboard/users.edit',
            [
                'user' => User::where('id', $user)->first()
            ]
        );
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
        $user = User::where('id', $request->id)->first();

        $user->update($request->all());

        return redirect()->route('dashboard.users.show', [
            'user' => User::where('id', $user->id)->first()
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
        $user = User::where('id', $request->user);

        $user->delete();

        return redirect()->route('dashboard.users', [
            'users' => User::all()
        ]);
    }

    public function permissions(int $id)
    {

        // $array = (User::find($id)->permissions()->pluck('permission_id')->toArray());
        // dd(array_key_exists('0',$array));
        return view('dashboard/users.permissions', [
            'user' => User::where('id', $id)->first(),
            'permissions' => Permission::all(),
            'user_permissions' => User::find($id)->permissions()->pluck('permission_id')->toArray()
        ]);
    }

    public function roles(int $id)
    {

        // $array = (User::find($id)->roles()->pluck('permission_id')->toArray());
        // dd(array_key_exists('0',$array));
        return view('dashboard/users.roles', [
            'user' => User::where('id', $id)->first(),
            'roles' => Role::all(),
            'user_roles' => User::find($id)->roles()->pluck('role_id')->toArray()
        ]);
    }

    public function permissionsUpdate(User $user, Request $request)
    {

        $user->syncPermissions($request->permissions);

        return redirect()->route('dashboard.users.show', [
            'user' => $user
        ]);
    }

    public function rolesUpdate(User $user, Request $request)
    {

        $user->syncRoles($request->roles);

        return redirect()->route('dashboard.users.show', [
            'user' => $user
        ]);
    }

    public function generateSignature(User $user,Request $request)
    {
        $user->generateSignature($request->pass);

        return redirect()->route('dashboard.users.show',$user);
    }
}
