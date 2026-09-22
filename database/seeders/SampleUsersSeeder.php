<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@deped.gov.ph'],
            [
                'name' => 'Sample Admin',
                'google_id' => 'sample-admin-google-id',
                'avatar' => null,
                'office' => 'Schools Division Office',
                'role' => UserRole::ADMIN->value,
                'email_verified_at' => now(),
                'password' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'approver@deped.gov.ph'],
            [
                'name' => 'Sample Approver',
                'google_id' => 'sample-approver-google-id',
                'avatar' => null,
                'office' => 'Schools Division Office',
                'role' => UserRole::APPROVER->value,
                'email_verified_at' => now(),
                'password' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@deped.gov.ph'],
            [
                'name' => 'Sample User',
                'google_id' => 'sample-user-google-id',
                'avatar' => null,
                'office' => 'School',
                'role' => UserRole::USER->value,
                'email_verified_at' => now(),
                'password' => null,
            ]
        );
    }
}
