<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProjectSeeder::class,
            ProfessionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
