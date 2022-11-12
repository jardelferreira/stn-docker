<?php

namespace Database\Factories;

use App\Models\Profession;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'slug' => Str::random(),
            'registration' => $this->faker->phoneNumber(),
            'cpf' => $this->faker->phoneNumber(),
            'admission' => $this->faker->date(),
            'profession_id' => Profession::all('id')->random()
        ];
    }
}
