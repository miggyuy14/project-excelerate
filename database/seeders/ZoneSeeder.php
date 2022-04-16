<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Zone::create([
            'name' => 'Zone 1'
        ]);
        Zone::create([
            'name' => 'Zone 2'
        ]);
        Zone::create([
            'name' => 'Zone 3'
        ]);
        Zone::create([
            'name' => 'Zone 4'
        ]);
        Zone::create([
            'name' => 'Zone 5'
        ]);
        Zone::create([
            'name' => 'Zone 6'
        ]);
        Zone::create([
            'name' => 'Zone 7'
        ]);
        Zone::create([
            'name' => 'Zone 8'
        ]);
    }
}
