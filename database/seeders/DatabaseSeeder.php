<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $users = [
            // ADMIN
            [
                'id' => Str::uuid(),
                'profession' => null,
                'first_name' => 'System',
                'middle_name' => null,
                'last_name' => 'Administrator',
                'suffix' => null,
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'email' => 'admin@gov.com',
                'password' => Hash::make('admin123'),
                'phone' => '09170000001',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Municipal Hall',
                'role' => 'admin',
                'email_verified_at' => $now,
                'pre_registration_status' => 'approved',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // OBO
            [
                'id' => Str::uuid(),
                'profession' => null,
                'first_name' => 'Building',
                'middle_name' => null,
                'last_name' => 'Official',
                'suffix' => null,
                'birth_date' => '1985-01-01',
                'gender' => 'male',
                'email' => 'buildingOfficial@gov.com',
                'password' => Hash::make('password123'),
                'phone' => '09170000002',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Municipal Hall',
                'role' => 'obo',
                'email_verified_at' => $now,
                'pre_registration_status' => 'approved',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('✅ Admin and OBO users seeded successfully.');
    }
}
