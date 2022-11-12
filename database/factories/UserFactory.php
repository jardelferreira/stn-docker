<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'usuario123', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function configure()
    {
        return $this->afterMaking(function(User $user){

        })->afterCreating(function(User $user){

            $user->providers()->save(Provider::factory(['user_id' => $user->id])->create());
            $user->employees()->save(Employee::factory(['user_id' => $user->id])->create());            
        });
        
    }
}
