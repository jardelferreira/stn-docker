<?php

namespace Database\Factories;

use App\Models\Base;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::random(),
            'description' => $this->faker->text(20),
            'place' => $this->faker->locale(),
            'uuid' => $this->faker->uuid()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Base $base){

        })->afterCreating(function (Base $base){
            Sector::factory(2)->create([
                'base_id' => $base->id,
                'project_id' => $base->project_id
            ]);
        });
    }
}
