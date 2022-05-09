<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $user->attachRole(3);

        $user = User::find(2);
        $user->attachRole(6);

        $user = User::find(3);
        $user->attachRole(5);
    }
}
