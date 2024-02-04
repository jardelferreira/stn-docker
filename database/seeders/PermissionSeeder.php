<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Yajra\Acl\Models\Permission;
use App\Repositories\PermissionRepository;

class PermissionSeeder extends Seeder
{
    protected $permissionsRepository;
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionsRepository = $permissionRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Permission::all() as $permission) {
            $permission->delete();
        }
        $permissions = ['dashboard', 'financeiro', 'filial','custos','public', "acl", "suprimentos", "dp", "projetos",'bases','setores','admin'];
        $id = [];
        foreach ($permissions as $permission) {

           $created = Permission::create([
                'name' => $permission,
                'slug' => Str::slug($permission, '-'),
                'resource' => "System",
                'System' => true
            ]);
            array_push($id,$created->id);
        }

        foreach ($this->permissionsRepository->getResources() as $resources) {
            foreach ($resources['permissions'] as $permission) {
                Permission::create($permission);
            }
        }

        User::find(1)->permissions()->attach($id);
    }
}
