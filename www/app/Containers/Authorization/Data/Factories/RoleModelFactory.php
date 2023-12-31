<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Data\Factories;

use App\Containers\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

final class RoleModelFactory extends Factory
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
     * @return array{name: string, description: string}
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(100),
        ];
    }
}
