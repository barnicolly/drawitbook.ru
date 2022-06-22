<?php

namespace App\Containers\User\Data\Factories;

use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class UserModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        'name' => "string",
        'email' => "string",
        'email_verified_at' => "string",
        'password' => "string",
    ])]
    public function definition(): array
    {
        $dateTime = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'email_verified_at' => $dateTime,
            'password' => $this->faker->password,
        ];
    }
}
