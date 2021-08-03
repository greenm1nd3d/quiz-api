<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@test.com',
            'password' => bcrypt('pass!234'),
            'user_type' => 'A',
            'status' => 'A'
        ]);

        User::create([
            'first_name' => 'Customer',
            'last_name' => 'One',
            'email' => 'customer@test.com',
            'password' => bcrypt('pass!234'),
            'user_type' => 'C',
            'status' => 'A'
        ]);
    }
}
