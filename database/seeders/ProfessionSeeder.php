<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professions = ['Almoxarife A','Engenheiro','Servente A','Montador B','Aux. de escritório', 'Gerente','Assistende Administrativo'];
        foreach ($professions as $profession) {
            Profession::factory()->create(['name' => $profession]);
        }
    }
}
