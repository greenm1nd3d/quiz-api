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
            'first_name' => 'Demo',
            'last_name' => 'Admin',
            'email' => 'demo@admin.com',
            'password' => bcrypt('demo!234'),
            'status' => 'A'
        ]);
    }
}
