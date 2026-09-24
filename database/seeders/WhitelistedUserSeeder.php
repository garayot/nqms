<?php

namespace Database\Seeders;

use App\Models\WhitelistedUser;
use Illuminate\Database\Seeder;

class WhitelistedUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            
            ['name' => 'Peter Ville Carmen', 'email' => 'peterville.carmen@deped.gov.ph', 'office' => 'Schools Division Office', 'is_active' => true],
        ];

        foreach ($users as $user) {
            WhitelistedUser::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
