<?php

namespace Database\Factories;

use App\Models\Cost;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $prefix = Str::random(4);
        return [
            'slug' => "PROJECT-{$prefix}",
            'description' => $this->faker->text(20),
            'initials' => "PJ-{$prefix}",
            'uuid' => $this->faker->uuid()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Project $project){

        })->afterCreating(function (Project $project){
            Cost::factory(2)->create(['project_id' => $project->id]);
        });
    }
}
