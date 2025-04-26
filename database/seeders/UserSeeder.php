<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // import the User model
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'firstname' => 'Trackpoint',
            'lastname' => 'Admin',
            'email' => 'admin@user.com',
            'password' => Hash::make('12345678'), // always hash passwords
            'role' => 'admin', // if you have a 'role' column
        ]);

          // Client User
          User::create([
            'firstname' => 'Trackpoint',
            'lastname' => 'Client',
            'email' => 'client@user.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);

        // Contractor User
        User::create([
            'firstname' => 'Trackpoint',
            'lastname' => 'Contractor',
            'email' => 'contractor@user.com',
            'password' => Hash::make('12345678'),
            'role' => 'contractor',
        ]);

        // Consultant User
        User::create([
            'firstname' => 'Trackpoint',
            'lastname' => 'Consultant',
            'email' => 'consultant@user.com',
            'password' => Hash::make('12345678'),
            'role' => 'consultant',
        ]);
        
    }
}
