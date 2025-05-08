<?php

namespace Database\Seeders;

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
       DB::table('users')->insert([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make(123),
        'phone'=>'1',
        'cep'=>'1',
        'address_street'=>'a',
        'address_number'=>'3',
        'address_city'=>'a',
        'state_id'=>'1',
        'image'=>'default.png'
       ]);
    }
}
