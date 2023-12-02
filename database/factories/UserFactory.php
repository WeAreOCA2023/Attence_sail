<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\UserLogin;
use App\Models\User;
use App\Models\AllWorkHours;
use Faker\Factory as Faker;


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
        $faker = \Faker\Factory::create('ja_JP');

        do {
            // Insert data into UserLoginTable
            $userLogin = UserLogin::create([
                "email" => $faker->unique()->safeEmail,
                "password" => 'yIXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ]);

            $allWorkHours = AllWorkHours::create([
                'user_id' => $userLogin->id,
                'weekly_total_work_hours' => 0,
                'monthly_total_work_hours' => 0,
                'yearly_total_work_hours' => 0,
                'total_over_work_hours' => 0,
            ]);

            // Generate random values for agreement_36 and variable_working_hours_system
            $agreement_36 = $faker->numberBetween(1, 3);
            $variable_working_hours_system = $faker->numberBetween(1, 2);

        } while (($agreement_36 == 1 && $variable_working_hours_system == 1) || ($agreement_36 == 2 && $variable_working_hours_system == 1));

        // Insert data into UsersTable
        return [
            'user_id' => $userLogin->id,
            'user_name' => $faker->name(),
            'full_name' => $faker->name(),
            'telephone' => $faker->phoneNumber(),
            'company_id' => 1,
            'department_id' => $faker->numberBetween(1, 9),
            'position_id' => $faker->numberBetween(1, 13),
            'status' => $faker->numberBetween(0, 4),
            'agreement_36' => $agreement_36,
            'variable_working_hours_system' => $variable_working_hours_system,
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
