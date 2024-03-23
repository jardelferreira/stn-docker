<?php

namespace App\Models;

use Yajra\Acl\Models\Role;
use Illuminate\Support\Str;
use Yajra\Acl\Models\Permission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Repositories\PermissionRepository;
use Yajra\Acl\Traits\HasRoleAndPermission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image_path',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $cipher = "aes-128-gcm";

    public function projects()
    {
        return $this->belongsToMany(Project::class)->distinct('user_id');
    }
    
    public function scopeProjects():array
    {
        return User::find(auth()->user()->id)->projects()->pluck("project_id")->toArray();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function adminlte_profile_url()
    {
        return \route('dashboard.users.show', \auth()->user()->id);
    }

    public function signatures()
    {
        return $this->morphMany(Signature::class, 'signaturable');
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public static function usersForEmployee()
    {
        return User::leftJoin("employees",'users.id','=',"employees.user_id")->where("employees.user_id",null)->orderBy("users.id", 'DESC');
    }

    public function signature()
    {
        return $this->hasMany(SignatureUser::class)->latest()->first();
    }

    public function allSignaturesUser()
    {
        return $this->hasMany(SignatureUser::class);
    }

    public function sectors()
    {
        return $this->belongsToMany(Project::class,'project_user')->join('sectors',"sectors.project_id","=","projects.id")->select("sectors.name as sector", "sectors.id as sector_id","projects.name as project")->get();
    }

    public function generateSignature($pass, $event = "Primeira Assinatura")
    {
        // dd();
        $signature_pass = $this->encryptPass($pass);
        // dd($signature_pass,$this->decryptPass($signature_pass));
            $signature = $this->signatures()->save(Signature::create([
            'user_id' => Auth::user()->id,
            'signature' => Hash::make($signature_pass),
            'signaturable_type' => get_class($this),
            'signaturable_id'   => $this->id,
            'event' => $event,
            'uuid' => Str::uuid(),
        ]));
        $user_signature = SignatureUser::create([
            'user_id' => $this->id,
            'signature_id' => $signature->id,
            'signature' => $signature_pass
        ]);
        
        return $signature;
    }


    public function hasSignature()
    {
        return $this->signatures()->count() ? true : false;
    }

    
    public function encryptPass($simple_string)
    {
    
        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = substr($this->uuid,0,16);

        // Store the encryption key
        $encryption_key = "jardel@mail";

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt(
            $simple_string,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );
        return $encryption;
    }

    public function decryptPass($encryption)
    {
        $ciphering = "AES-128-CTR";
        $decryption_key = "jardel@mail";
        $decryption_iv = substr($this->uuid,0,16);
        $options = 0;

       // Use openssl_decrypt() function to decrypt the data
       $decryption = openssl_decrypt(
        $encryption,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );
    return $decryption;
    }

    public function checkSignature($pass,$agent = "usuário")
    {
        if($pass != null){

            if($this->signature()->signature == $this->encryptPass($pass)){
                return array(
                    'success' => true,
                    'message' => "Senha de {$agent} correta"
                );
            }
            elseif(array_key_exists($this->encryptPass($pass),$this->allSignaturesUser()->pluck('signature')->toArray())) {
                return array(
                    'success' => false,
                    'message' => "O {$agent} está tentando usar uma senha antiga.",
                    'type' => 'warning',
                    "footer" => "erro de senha"
                );

            }else{
                return array(
                    'success' => false,
                    'message' => "Senha de {$agent} incorreta",
                    'type' => 'error',
                    'footer' => "Erro de Senha.",
                );
            }
        }else{
            return array(
                'success' => false,
                'message' => "informe uma senha de {$agent}",
                'footer' => "Erro de Senha.",
                'type' => 'warning',
            );
        }
            
        
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['acl','admin'];
        foreach ($permissionRepository->getResources()['acl-users']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
    
    public static function resourcesPublicModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['public','admin'];
        foreach ($permissionRepository->getResources()['public']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }

    public function adminlte_image()
    {
        return auth()->user()->image_path ? asset(auth()->user()->image_path) : "https://bootdey.com/img/Content/avatar/avatar7.png";
    }

    public function biometric()
    {
        return $this->hasOne(Biometric::class);
    }

    public function usersAvaliableToBiometric()
    {
        $user_projects = auth()->user()->projects()->with("users")->get()->pluck("users.*.id")->toArray();
        $user_projects = count($user_projects) > 1 ? array_merge_recursive_distinct(...$user_projects): $user_projects[0];
        $user_biometrics = Biometric::pluck("user_id")->toArray();
        return User::all()->whereNotIn("id",$user_biometrics)->whereIn("id",$user_projects);
    }

    public function usersWithBiometric()
    {
        $user_projects = auth()->user()->projects()->with("users")->get()->pluck("users.*.id")->toArray();
        $user_projects = count($user_projects) > 1 ? array_merge_recursive_distinct(...$user_projects): $user_projects[0];
        return Biometric::select('user_id as id','template as digital')->whereIn('user_id',$user_projects);
    }   
}
