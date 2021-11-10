<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create client
        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('client'),
            'role' => 'CLIENT',
            'avatar' => url('/dist/img/avatar.png')
        ])
        ->detail()
        ->create([
            'pet_name' => 'Mossai',
            'pet_category' => 'Cat',
            'address' => 'PADS',
            'contact_number' => '09123456789'
        ]);

        // Create staff user
        User::create([
            'name' => 'Kath',
            'email' => 'kath@gmail.com',
            'password' => bcrypt('staff'),
            'role' => 'STAFF',
            'avatar' => url('/dist/img/avatar.png')
        ])
        ->detail()
        ->create([
            'address' => 'PADS',
            'contact_number' => '09123456789'
        ]);

        // Create admin user
        User::create([
            'name' => 'Mel',
            'email' => 'mel@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'ADMIN',
            'avatar' => url('/dist/img/avatar.png')
        ])
        ->detail()
        ->create([
            'address' => 'PADS',
            'contact_number' => '09123456789'
        ]);
    }
}
 