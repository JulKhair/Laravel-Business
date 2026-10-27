<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Velscania Tempest',
                'password' => Hash::make('StaffPassword123!'),
            ]
        );
    }
}
