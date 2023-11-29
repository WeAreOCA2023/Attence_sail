<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Department;
use App\Models\Company;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\AllWorkHours;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // adminアカウント作成
         $userLogin = UserLogin::create([
             "email" => 'test-boss@test.com',
             "password" => 'test@123',
         ]);

         $company = Company::create([
             'company_name' => '株式会社アテンス',
             'company_code' => '111111111111',
             'company_password' => 'test@123',
             'post_code' => '1111111',
             'address' => '東京都渋谷区渋谷1-1-1',
         ]);

         $user = User::create([
             'user_id' => $userLogin->id,
             'user_name' => 'test-boss',
             'full_name' => 'Admin',
             'telephone' => '11111111111',
             'company_id' => 1,
             'is_boss' => 1,
             'department_id' => 0,
             'position_id' => 0,
             'status' => 0,
             'agreement_36' => 0,
             'variable_working_hours_system' => 0,
         ]);

         $allWorkHours = AllWorkHours::create([
             'user_id' => $userLogin->id,
             'weekly_total_work_hours' => 0,
             'monthly_total_work_hours' => 0,
             'yearly_total_work_hours' => 0,
             'total_over_work_hours' => 0,
         ]);

        // これより下は一般用のテストデータ
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

        $departments = [
            '営業部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            '開発部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            '情報システム部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            '経理部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            '総務部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            '法務部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            'CS部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            'マーケティング' => [
                'company_id' => '1',
                'boss_id' => '1'
            ],
            '技術部' => [
                'company_id' => '1',
                'boss_id' => '1'
            ]
        ];

        foreach ($positions as $position_name => $rank) {
            Position::factory()->create([
                'position_name' => $position_name,
                'rank' => $rank,
            ]);
        }

        foreach ($departments as $department => $department_info) {
            Department::factory()->create([
                'department_name' => $department,
                'company_id' => $department_info['company_id'],
                'boss_id' => $department_info['boss_id'],
            ]);
        }

        User::factory(20)->create();
    }
}
