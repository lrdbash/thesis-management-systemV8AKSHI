<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if user with mitchel.openda@strathmore.edu exists
        if (!User::where('email', 'mitchel.openda@strathmore.edu')->exists()) {
            // Create a student user
            User::create([
                'name' => 'Mitchel Openda',
                'email' => 'mitchel.openda@strathmore.edu',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
        }

        // Check if user with dr.bernard.shibabwe@strathmore.edu exists
        if (!User::where('email', 'dr.bernard.shibabwe@strathmore.edu')->exists()) {
            // Create a staff user
            User::create([
                'name' => 'Dr Bernard Shibabwe',
                'email' => 'dr.bernard.shibabwe@strathmore.edu',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]);
        }

        // Check if user with admin@example.com exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            // Create an admin user
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }
    }
}
