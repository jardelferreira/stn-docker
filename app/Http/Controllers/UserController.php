<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Signature;
use Yajra\Acl\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Acl\Models\Permission;
use App\Http\Requests\UserRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:acl,admin,dp,listar-acl-usuarios');
        $this->middleware('can:acl,admin,criar-acl-usuarios,gerenciar-acl-usuarios')->only(['create','store']);
        $this->middleware('can:acl,admin,gerenciar-acl-usuarios,editar-acl-usuarios')->only(['edit','update']);
        $this->middleware('can:acl,admin,deletar-acl-usuarios,gerenciar-acl-usuarios')->only(['destroy']);
        $this->middleware('can:acl,admin,gerenciar-acl-usuarios')->only(['attachProject','detachProject']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(User::with('employee')->get()[0]);
        // dd(User::all()[0]->employee()->first());
        return \view('dashboard.users.index', [
            'users' => User::all(),
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
    public function edit(User $user)
    {
        return view(
            'dashboard/users.edit',
            [
                'user' => $user
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
    public function permissions(User $user)
    {
        // dd(Permission::get()->chunk(3));
        // $array = (User::find($id)->permissions()->pluck('permission_id')->toArray());
        // dd(array_key_exists('0',$array));
        return view('dashboard/users.permissions', [
            'user' => $user,
            'permissions' => Permission::get()->chunk(4),
            'user_permissions' => $user->permissions()->pluck('permission_id')->toArray()
        ]);
    }
    public function roles(User $user)
    {
        return view('dashboard/users.roles', [
            'user' => $user,
            'roles' => Role::all(),
            'user_roles' => $user->roles()->pluck('role_id')->toArray()
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

    function checkSignature(Request $request) {
        
        $user = User::where('id',Auth::user()->id)->first();
        return $user->checkSignature($request->pass);
    }

    public function projects(USer $user)
    {
        return view('dashboard.users.projects',[
            'user' => $user,
            'projects' => Project::withoutGlobalScopes()->get(),
            'user_projects' => $user->projects()->pluck("projects.id")->toArray()
        ]);
    }

    public function attachProject(User $user, Request $request)
    {
    
        $user->projects()->attach($request->project_id);

        return redirect()->back();
    }
    
    public function detachProject(User $user, Request $request)
    {
        $user->projects()->detach($request->project_id);

        return redirect()->back();
    }

}
