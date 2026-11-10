<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@isp.com'],
            [
                'name' => 'Administrator',
                'password' => 'Admin12345!',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@isp.com'],
            [
                'name' => 'Staff ISP',
                'password' => 'Staff12345!',
                'role' => 'staff',
            ]
        );
    }
}
