<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()
        //     ->count(5)
        //     ->create();
        
        $user = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
 
        // $user->roles()->attach(1);
    }
}
