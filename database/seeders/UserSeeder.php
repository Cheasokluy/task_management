<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('users')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        //create one admin user 
        // User::created([
        //     'name' =>'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'), // Secure password
        //     'role' => 'admin', // Assign the role
        // ]);
        // Create 20 regular users using a factory
        

        // User::factory(20)->create([
        //     'name' => 'Regular User',
        //     'email' => fake()->unique()->safeEmail(),
        //     'password' => Hash::make('password'),
        //     'role' => 'user',
        // ]);

    }
}
