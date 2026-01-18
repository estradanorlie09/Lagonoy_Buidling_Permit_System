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
                'email_verified_at' => $now,
                'password' => Hash::make('admin123'),
                'phone' => '09170000001',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Municipal Hall',
                'role' => 'admin',
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
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000002',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Municipal Hall',
                'role' => 'obo',
            ],

            // ZONING OFFICER
            [
                'id' => Str::uuid(),
                'profession' => null,
                'first_name' => 'Zoning',
                'middle_name' => null,
                'last_name' => 'Officer',
                'suffix' => null,
                'birth_date' => '1986-01-01',
                'gender' => 'female',
                'email' => 'zoningOfficer@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000003',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Municipal Hall',
                'role' => 'zoning_officer',
            ],

            // SANITARY OFFICER
            [
                'id' => Str::uuid(),
                'profession' => null,
                'first_name' => 'Sanitary',
                'middle_name' => null,
                'last_name' => 'Officer',
                'suffix' => null,
                'birth_date' => '1987-01-01',
                'gender' => 'female',
                'email' => 'sanitaryOfficial@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000004',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Municipal Hall',
                'role' => 'sanitary_officer',
            ],

            // PROFESSIONALS
            [
                'id' => Str::uuid(),
                'profession' => 'architect',
                'first_name' => 'Professional',
                'middle_name' => null,
                'last_name' => 'Architect',
                'suffix' => null,
                'birth_date' => '1980-01-01',
                'gender' => 'male',
                'email' => 'professionalArchi@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000005',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Private Office',
                'role' => 'professional',
            ],
            [
                'id' => Str::uuid(),
                'profession' => 'civil_engineer',
                'first_name' => 'Professional',
                'middle_name' => null,
                'last_name' => 'Civil',
                'suffix' => null,
                'birth_date' => '1980-01-01',
                'gender' => 'male',
                'email' => 'professionalCivil@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000006',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Private Office',
                'role' => 'professional',
            ],
            [
                'id' => Str::uuid(),
                'profession' => 'electrical_engineer',
                'first_name' => 'Professional',
                'middle_name' => null,
                'last_name' => 'Electrical',
                'suffix' => null,
                'birth_date' => '1980-01-01',
                'gender' => 'male',
                'email' => 'professionalElectrical@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000007',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Private Office',
                'role' => 'professional',
            ],
            [
                'id' => Str::uuid(),
                'profession' => 'sanitary_engineer',
                'first_name' => 'Professional',
                'middle_name' => null,
                'last_name' => 'Sanitary',
                'suffix' => null,
                'birth_date' => '1980-01-01',
                'gender' => 'female',
                'email' => 'professionalSanitary@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000008',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Private Office',
                'role' => 'professional',
            ],
            [
                'id' => Str::uuid(),
                'profession' => 'master_plumber',
                'first_name' => 'Professional',
                'middle_name' => null,
                'last_name' => 'Plumber',
                'suffix' => null,
                'birth_date' => '1980-01-01',
                'gender' => 'male',
                'email' => 'professionalMasterPlumber@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000009',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Private Office',
                'role' => 'professional',
            ],
            [
                'id' => Str::uuid(),
                'profession' => 'geodetic_engineer',
                'first_name' => 'Professional',
                'middle_name' => null,
                'last_name' => 'Geodetic',
                'suffix' => null,
                'birth_date' => '1980-01-01',
                'gender' => 'male',
                'email' => 'professionalGeodetic@gov.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'phone' => '09170000010',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Private Office',
                'role' => 'professional',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                array_merge($user, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }

        $this->command->info('✅ System users seeded and email verified.');
    }
}
