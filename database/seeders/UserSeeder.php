<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => 'password',
            'is_admin' => true
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@user',
            'password' => 'password',
            'is_admin' => false
        ]);
    }
}
