<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->name(),
            'email'         => fake()->unique()->safeEmail(),
            'password'      => Hash::make('admin'),
            'age'           => fake()->numberBetween(18, 60),
            'phone'           => fake()->phoneNumber(),
            'department_id' => fake()->numberBetween(1, 6),
        ];
    }
}
