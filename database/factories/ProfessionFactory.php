<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(25),
            'salary' => $this->faker->floatval(),
            'aditional' => false,
            'percent' => 0.3
        ];
    }
}
