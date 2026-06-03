<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TripType;


class TripTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        TripType::insert([
            [
                'name' => 'Honeymoon',
                'slug' => 'honeymoon',
                'status' => true
            ],
            [
                'name' => 'Family',
                'slug' => 'family',
                'status' => true
            ],
            [
                'name' => 'Adventure',
                'slug' => 'adventure',
                'status' => true
            ]
        ]);
    }
}
