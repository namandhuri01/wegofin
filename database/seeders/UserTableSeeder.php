<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert([
            'name' => 'Developer',
            'email' => 'developer@example.com',
            'password' => Hash::make('Test@Password123#'),
        ]);
    }
}
