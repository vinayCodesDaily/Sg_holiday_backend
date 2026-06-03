<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'role_id' => 1,
            'name' => 'Super Admin',
            'email' => 'admin@sgholidays.com',
            'phone' => '9999999999',
            'password' => Hash::make('password123'),
            'status' => true,
        ]);
    }
}
