<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'uuid' => Str::uuid(),
        //     'name' => "Jardel Ferreira de Sousa",
        //     'email' => "jardel@mail",
        //     'email_verified_at' => now(),
        //     'password' => "jardel123", // password
        //     'remember_token' => Str::random(10),
        // ]);

        User::factory(4)->create();
    }
}
