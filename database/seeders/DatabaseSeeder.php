<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        User::insert([
            [
                'id' => Str::uuid(),
                'profession' => null,
                'first_name' => 'System',
                'middle_name' => null,
                'last_name' => 'Administrator',
                'suffix' => null,
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'phone' => '09171234567',
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => 'San Rafael',
                'street' => 'Municipal Hall',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $faker = \Faker\Factory::create();

        $roles = [
            'applicant',
            'zoning_officer',
            'sanitary_officer',
            'obo',
            'do',
            'bfp',
            'professional',
        ];

        $professions = [
            'architect',
            'civil_engineer',
            'electrical_engineer',
            'sanitary_engineer',
            'master_plumber',
            'geodetic_engineer',
        ];

        $users = [];

        for ($i = 1; $i <= 20; $i++) {
            $role = $faker->randomElement($roles);

            $users[] = [
                'id' => Str::uuid(),
                'profession' => $role === 'professional' ? $faker->randomElement($professions) : null,
                'first_name' => $faker->firstName(),
                'middle_name' => $faker->optional()->firstName(),
                'last_name' => $faker->lastName(),
                'suffix' => $faker->optional()->randomElement(['Jr', 'Sr', 'II', 'III', null]),
                'birth_date' => $faker->date('Y-m-d', '2002-01-01'),
                'gender' => $faker->randomElement(['male', 'female']),
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password123'),
                'phone' => $faker->phoneNumber(),
                'province' => 'Camarines Sur',
                'municipality' => 'Lagonoy',
                'barangay' => $faker->word(),
                'street' => $faker->streetAddress(),
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        User::insert($users);

       
        $this->command->info('✅ Database seeded successfully with 1 admin + 20 users.');
    }
}
