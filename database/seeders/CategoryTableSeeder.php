<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'ورزشی',
            'اقتصادی',
            'حوادث',
            'فرهنگی',
            'تاریخی'
        ];
        $type = ['news','article'];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'type' => $type[rand(0,1)],
                'status' => rand(0,1),
                'created_at' => now()
            ]);
        }
    }
}
