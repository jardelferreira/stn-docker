<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Signature;
use Yajra\Acl\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Acl\Models\Permission;
use App\Http\Requests\UserRequest;
use App\Models\Biometric;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNan;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:acl,admin,dp,listar-acl-usuarios');
        $this->middleware('can:acl,admin,criar-acl-usuarios,gerenciar-acl-usuarios')->only(['create', 'store']);
        $this->middleware('can:acl,admin,gerenciar-acl-usuarios,editar-acl-usuarios')->only(['edit', 'update']);
        $this->middleware('can:acl,admin,deletar-acl-usuarios,gerenciar-acl-usuarios')->only(['destroy']);
        $this->middleware('can:acl,admin,gerenciar-acl-usuarios')->only(['attachProject', 'detachProject']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(User::with('employees')->get());
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
       $user = $user->create($request->all());
        if ($request->biometric) {
            return redirect()->route('dashboard.users.show', [
                'user' => $user
            ]);
        }
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
        // dd($user->projects()->with('users.biometric')->get()->toArray());
        // dd($user->biometric->first());
        // dd($user->decryptPass($user->signature()->signature));
        // dd($user->signature(),auth()->user()->signature());
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
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard.users', [
            'users' => User::all()
        ]);
    }

    public function updateImageProfile(User $user, Request $request)
    {
        if ($request->hasFile('file')) {
            $name = $request->file('file')->getClientOriginalName();
            $extension = $request->file('file')->extension();
            $path = $request->file('file')->storeAs('public/users/profile', "{$user->uuid}.{$extension}");
            $path = \str_replace('public', 'storage', $path);
            $user->update(['image_path' => "{$path}"]);
            return true;
        }
        return false;
    }

    public function updateSignaturePass(User $user, Request $request)
    {
        if (Hash::check($request->password, $user->password)) {
            $user->generateSignature($request->signature);
            return redirect()->back()->with('success', 'Nova assinatura gerada com sucesso!');
        } else {
            return redirect()->back()->with('error', "Senha incorreta");
        }
        return redirect()->back()->with('error', 'Não foi possível gerar assinatura.');
    }

    public function updatePassword(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_password' => "required|min:8",
            'new_password' => "required|min:8",
            'new_password_confirm' => "required|min:8",
        ], [
            'user_password.required' => "Senha do usuário é obrigatória",
            'user_password.min' => "A senha deve conter no mínimo 8 caracters",
            'new_password.required' => "Nova senha do usuário é obrigatória",
            'new_password.min' => "A nova senha deve conter no mínimo 8 caracters",
            'new_password_confirm.required' => "Nova senha do usuário é obrigatória",
            'new_password_confirm.min' => "A nova senha deve conter no mínimo 8 caracters",

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!(Hash::check($request->user_password, auth()->user()->password))) {
            return redirect()->back()->with('error', "Senha incorreta");
        }
        if ($request->new_password == $request->new_password_confirm) {
            $user->update(['password' => Hash::make($request->new_password)]);
            return redirect()->back()->with('success', 'Senha alterada com sucesso!');
        } else {
            return redirect()->back()->with('error', 'As senhas precisam ser iguais!');
        }
    }
    public function permissions(User $user)
    {
        $permissions = Permission::get();

        $mod = ($permissions->count() % 4);
        // $array = (User::find($id)->permissions()->pluck('permission_id')->toArray());
        // dd(array_key_exists('0',$array));
        return view('dashboard/users.permissions', [
            'user' => $user,
            'permissions' => $permissions->chunk(4),
            'user_permissions' => $user->permissions()->pluck('permission_id')->toArray(),
            'count' => ($mod > 0) ? (4 - $mod):0
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

    public function generateSignature(User $user, Request $request)
    {
        $user->generateSignature($request->pass);

        return redirect()->route('dashboard.users.show', $user);
    }

    function checkSignature(Request $request)
    {

        // $user = User::where('id',Auth::user()->id)->first();
        return auth()->user()->checkSignature($request->pass);
    }

    public function projects(USer $user)
    {
        return view('dashboard.users.projects', [
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

    public function biometricStore(User $user, Request $request)
    {
        // return $request->all();
        $id = is_numeric($user->id) ? $user->id : $request->id; 
        
        Biometric::create([
            "user_id" => $id,
            "template" => $request->template
        ]);
        if (!$user->id) {
         $user = User::where("id",$id)->first();
        }
        return response()->json([
            "user" => $user,
            "template" => $user->biometric()->first()->template,
        ]);
    }
}
