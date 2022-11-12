<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\sectorsCosts;
use App\Models\DepartamentCost;
use Illuminate\Database\Eloquent\Factories\Factory;

class sectorsCostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = Str::random(10);
        return [
            'name' => "Setor - {$name}",
            'amount' => 0,
            'description' => $this->faker->text(20),
            'slug' => Str::random(),
            'uuid' => $this->faker->uuid()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (sectorsCosts $sectorCost){

        })->afterCreating(function (sectorsCosts $sectorCost){
            DepartamentCost::factory(2)->create([
                'cost_center_id' => $sectorCost->cost_center_id,
                'cost_sector_id' => $sectorCost->id,
                'project_id' => $sectorCost->project_id
            ]);
        });
    }
}
