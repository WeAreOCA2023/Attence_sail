<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\UserLogin;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
        define(UserLogin::class, function (Faker\Generator $faker) {
            return [
                "email" => $faker->unique()->safeEmail,
                "password" => 'yIXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ];
        });
        $userLogin = factory(UserLogin::class)->create();
        return [
            'user_id' => $userLogin->id,
            'user_name' => fake()->name(),
            'full_name' => fake()->name(),
            'telephone' => fake()->phoneNumber(),
            'company_id' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
