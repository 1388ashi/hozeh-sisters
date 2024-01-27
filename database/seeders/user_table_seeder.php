<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class user_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
                'name' => 'admin1',
                'phone' => '09334496439',
                'email' => 'admin@gmail.com',
                'password' => Hash::make(123456),
         ];

        DB::table('users')->insert([
            'name' => $users['name'],
            'phone' => $users['phone'],
            'email' => $users['email'],
            'password' => $users['password'],
         ]);
    }
}
