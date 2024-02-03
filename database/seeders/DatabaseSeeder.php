<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            PermissionSeeder::class,
            UserSeeder::class,
            TasksTableSeeder::class,
            // LinksTableSeeder::class,
        ]);
    }
}
