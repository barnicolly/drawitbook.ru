<?php

namespace App\Containers\Authorization\Data\Factories;

use App\Containers\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class RoleModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'description' => "string"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(100),
        ];
    }
}

