<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = ['NTS Instalações de esferas','LT 138KV KARPOWERSHIP', 'SE LIGHT SANTA CRUZ','SOT AT-RJ','SUBTERRÂNEO'];
        foreach ($projects as $project) {
            Project::factory()->create(['name' => $project]);          
        }
    }
}
