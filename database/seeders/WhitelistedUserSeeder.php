<?php

namespace Database\Seeders;

use App\Models\WhitelistedUser;
use Illuminate\Database\Seeder;

class WhitelistedUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Sample Admin', 'email' => 'admin@deped.gov.ph', 'office' => 'Schools Division Office', 'is_active' => true],
            ['name' => 'Sample Approver', 'email' => 'approver@deped.gov.ph', 'office' => 'Schools Division Office', 'is_active' => true],
            ['name' => 'Sample User', 'email' => 'user@deped.gov.ph', 'office' => 'School', 'is_active' => true],
        ];

        foreach ($users as $user) {
            WhitelistedUser::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
