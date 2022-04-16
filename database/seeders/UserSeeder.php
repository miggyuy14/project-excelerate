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
            'email' => 'admin@brgy.com',
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
    }
}
