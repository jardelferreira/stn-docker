<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = $this->faker->company();
        $sufix = $this->faker->companySuffix();
        return [
            'corporate_name' => $company,
            'fantasy_name' => "fantasy-{$sufix}",
            'cnpj' => $this->faker->phoneNumber(),
            'headquarters' => 0,
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'slug' => $this->faker->slug(),
            'uuid' => $this->faker->uuid(),
        ];
    }
}
