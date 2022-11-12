<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProfessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'slug' => Str::random(),
            'description' => $this->faker->text(25),
            'salary' => 1000,
            'aditional' => false,
            'percent' => 0.3
        ];
    }
    
}
