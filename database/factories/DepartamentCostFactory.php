<?php

namespace Database\Factories;

use App\Models\DepartamentCost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DepartamentCostFactory extends Factory
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
            'name' => $name,
            'amount' => 0,
            'slug' => Str::random(),
            'description' => $this->faker->text(20),
            'uuid' => $this->faker->uuid()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (DepartamentCost $departamentCost){

        })->afterCreating(function (DepartamentCost $sectorCost){
            
        });
    }
}
