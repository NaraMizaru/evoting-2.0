<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'fullname' => 'Administrator',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'unencrypted_password' => 'admin',
            'role' => 'admin',
        ]);

        User::create([
            'fullname' => 'Administrator-2',
            'username' => 'admin2',
            'password' => bcrypt('admin2'),
            'unencrypted_password' => 'admin2',
            'role' => 'admin',
        ]);
    }
}
