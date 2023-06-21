<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Royal Bengal Tiger',
            'collections' => '1,2,3,4',
            'tags' => 'tiger, sundarban, bangladesh'
        ]);

        DB::table('products')->insert([
            'name' => 'Cat',
            'collections' => '1,3,4',
            'tags' => 'car, pet'
        ]);

        DB::table('products')->insert([
            'name' => 'Dog',
            'collections' => '1,2,4',
            'tags' => 'friend, watchman'
        ]);

        DB::table('products')->insert([
            'name' => 'Bird',
            'collections' => '1,2,3',
            'tags' => 'freedom, fly'
        ]);
    }
}
