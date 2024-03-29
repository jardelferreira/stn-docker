<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Yajra\Acl\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => "Adm do Sistema",
            'email' => "admin.sglt@mail",
            'email_verified_at' => now(),
            'password' => env("PASS_ADMIN","sglt1987"), // password
            'remember_token' => Str::random(10),
        ]);

        $permissions = Permission::all('name')->toArray();

        $user->syncPermissions($permissions);

        User::factory(4)->create();
    }
}
