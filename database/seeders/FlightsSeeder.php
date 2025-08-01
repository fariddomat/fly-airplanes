<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class FlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('airports')->insert([
            [
                'airport_code' => 'DAM',
                'airport_name' => 'Damascus International Airport',
                'city' => 'Damascus',
                'country' => 'Syria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'airport_code' => 'ALP',
                'airport_name' => 'Aleppo International Airport',
                'city' => 'Aleppo',
                'country' => 'Syria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'airport_code' => 'AMM',
                'airport_name' => 'Queen Alia International Airport',
                'city' => 'Amman',
                'country' => 'Jordan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'airport_code' => 'BEY',
                'airport_name' => 'Beirut-Rafic Hariri International Airport',
                'city' => 'Beirut',
                'country' => 'Lebanon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'airport_code' => 'CAI',
                'airport_name' => 'Cairo International Airport',
                'city' => 'Cairo',
                'country' => 'Egypt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

      
    }
}
