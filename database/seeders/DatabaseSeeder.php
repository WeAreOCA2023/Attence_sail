<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // \App\Models\UserLogin::factory(20)->create();
        // \App\Models\Position::factory(20)->create();
        // \App\Models\Department::factory(20)->create();
        // \App\Models\User::factory(20)->create();
        $positions = [
            '代表取締役社長' => 100,
            '副社長' => 90,
            '専務取締役' => 92,
            '常務取締役' => 85,
            '本部長' => 80,
            '部長' => 75,
            '次長' => 70,
            '課長' => 65,
            '係長' => 60,
            '主任' => 55,
            '一般' => 5,
            '派遣社員(A株式会社)' => 1,
            '業務委託先(B株式会社)' => 1
        ];
        foreach ($positions as $position_name => $rank) {
            Position::factory()->create([
                'position_name' => $position_name,
                'rank' => $rank,
            ]);
        }
    }
}
