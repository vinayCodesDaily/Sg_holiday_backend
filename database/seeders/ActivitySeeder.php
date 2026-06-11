<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::insert([
            [
                'name' => 'Trekking & Adventure',
                'slug' => 'trekking-adventure',
                'description' => 'Mountain expeditions, camping, and hiking tracks.',
                'image' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Water Sports & Beach',
                'slug' => 'water-sports-beach',
                'description' => 'Scuba diving, snorkeling, surfing, and boat tours.',
                'image' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Heritage & Culture',
                'slug' => 'heritage-culture',
                'description' => 'Guided city tours, monuments, temples, and culinary trips.',
                'image' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Wildlife & Safari',
                'slug' => 'wildlife-safari',
                'description' => 'National parks, jungle safaris, and nature trails.',
                'image' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Leisure & Wellness',
                'slug' => 'leisure-wellness',
                'description' => 'Resort retreats, spas, and yoga retreats.',
                'image' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
