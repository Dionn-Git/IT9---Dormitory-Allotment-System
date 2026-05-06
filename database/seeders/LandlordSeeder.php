<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LandlordSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Landlord',
            'phone'    => '09123456789',
            'email'    => 'landlord@dorm.com',
            'gender'   => 'male',
            'role'     => 'landlord',
            'position' => 'manager',
            'password' => Hash::make('password123'),
        ]);
    }
}