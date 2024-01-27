<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {  
        $this->call(user_table_seeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(SettingTableSeeder::class);
    }
}
