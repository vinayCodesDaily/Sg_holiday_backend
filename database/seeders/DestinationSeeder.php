<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Destination::insert([
            [
                'name' => 'Goa',
                'slug' => 'goa',
                'status' => true
            ],
            [
                'name' => 'Kerala',
                'slug' => 'kerala',
                'status' => true
            ],
            [
                'name' => 'Dubai',
                'slug' => 'dubai',
                'status' => true
            ]
        ]);
    }
}
