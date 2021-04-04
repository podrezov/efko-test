<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = '$2y$10$PTNM79HIs/ZJm0zlo/0wJO7DpSRfUH2J0iPb6imgWZkqzLlvEkw32'; # secret

        $testUsers = [
            [
                'fields' => [
                    'name' => 'director',
                    'email' => 'director@example.com',
                    'password' => $password,
                ],
                'role' => Role::DIRECTOR
            ],
            [
                'fields' => [
                    'name' => 'employee',
                    'email' => 'employee@example.com',
                    'password' => $password,
                ],
                'role' => Role::EMPLOYEE
            ]
        ];

        foreach ($testUsers as $testUser) {
            if (User::firstWhere('email', $testUser['fields']['email'])) {
                continue;
            }

            $user = User::create($testUser['fields']);
            $user->roles()->attach($testUser['role']);
        }
    }
}
