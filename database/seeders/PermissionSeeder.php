<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Yajra\Acl\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['dashboard','permissions-manager','roles-manager'];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'slug' => Str::slug($permission,'-')
            ]);
        }
    }
}
