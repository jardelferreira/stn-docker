<?php

namespace Database\Factories;

use App\Models\Cost;
use Illuminate\Support\Str;
use App\Models\sectorsCosts;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->text(10);
        return [
            'name' => "COST-{$name}",
            'description' => $this->faker->text(25),
            'amount' => 0,
            'slug' => Str::random(),
            'uuid' => $this->faker->uuid()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Cost $cost){

        })->afterCreating(function (Cost $cost){
            sectorsCosts::factory(2)->create([
                'cost_center_id' => $cost->id,
                'project_id' => $cost->project_id
            ]);
        });
    }
}
