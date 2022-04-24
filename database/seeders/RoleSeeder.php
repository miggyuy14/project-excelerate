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
        Role::create([
            'name' => 'resident',
            'display_name' => 'Resident'
        ]);
        Role::create([
            'name' => 'staff',
            'display_name' => 'Staff'
        ]);
        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);
        Role::create([
            'name' => 'zone_leader',
            'display_name' => 'Zone Leader'
        ]);
        Role::create([
            'name' => 'doctor',
            'display_name' => 'Doctor'
        ]);
        Role::create([
            'name' => 'nurse',
            'display_name' => 'Nurse'
        ]);
    }
}
