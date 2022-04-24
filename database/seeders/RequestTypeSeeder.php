<?php

namespace Database\Seeders;

use App\Models\RequestType;
use Illuminate\Database\Seeder;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestType::create([
            'name' => 'Barangay ID',
        ]);
        RequestType::create([
            'name' => 'Barangay Clearance',
        ]);
        RequestType::create([
            'name' => 'Business Permit',
        ]);
    }
}
