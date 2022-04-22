<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
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
        User::create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'active' => 1,
        ]);
        Profile::create([
            'first_name' => 'Barangay',
            'last_name' => 'Admin',
            'zone_id' => 1,
            'gender' => 'N/A',
            'marital_status' => 'N/A',
            'address' => 'N/A',
            'nationality' => 'N/A',
            'religion' => 'N/A',
            'occupation' => 'N/A',
            'household_count' => 0,
            'birthday' => Carbon::now()
        ]);

        User::create([
            'email' => 'leader@gmail.com',
            'password' => bcrypt('12345678'),
            'active' => 1,
        ]);
        Profile::create([
            'first_name' => 'Zone',
            'last_name' => 'Leader',
            'zone_id' => 1,
            'gender' => 'N/A',
            'marital_status' => 'N/A',
            'address' => 'N/A',
            'nationality' => 'N/A',
            'religion' => 'N/A',
            'occupation' => 'N/A',
            'household_count' => 0,
            'birthday' => Carbon::now()
        ]);

        User::create([
            'email' => 'resident@gmail.com',
            'password' => bcrypt('12345678'),
            'active' => 1,
        ]);
        Profile::create([
            'first_name' => 'Barangay',
            'last_name' => 'Resident',
            'zone_id' => 1,
            'gender' => 'N/A',
            'marital_status' => 'N/A',
            'address' => 'blk 1 lot 2 123 St. brgy testing, Manila',
            'nationality' => 'Filipino',
            'religion' => 'Catholic',
            'occupation' => 'Tambay',
            'household_count' => 5,
            'birthday' => Carbon::now()
        ]);
    }
}
