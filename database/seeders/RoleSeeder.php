<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'employee',
            'director'
        ];

        foreach ($roles as $role) {
            if (Role::firstWhere('name', $role)) {
                continue;
            }

            Role::create([
                'name' => $role
            ]);
        }
    }
}
