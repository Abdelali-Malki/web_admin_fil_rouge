<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CollectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collections')->insert([
            'name' => 'Animals'
        ]);

        DB::table('collections')->insert([
            'name' => 'Anime'
        ]);

        DB::table('collections')->insert([
            'name' => 'Logos'
        ]);

        DB::table('collections')->insert([
            'name' => 'Cars & Vehicles'
        ]);
    }
}
