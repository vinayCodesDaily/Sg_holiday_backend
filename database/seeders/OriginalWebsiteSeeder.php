<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\TripType;
use App\Models\Activity;
use Illuminate\Support\Str;

class OriginalWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Destinations (9 items)
        $destinations = [
            [
                'name' => 'Telangana',
                'description' => 'Explore the rich heritage, historic monuments, and beautiful culture of Telangana.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Andaman',
                'description' => 'Discover the pristine beaches, active volcanoes, and rich marine life in Andaman.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Goa',
                'description' => 'Unwind on the sandy beaches, enjoy vibrant nightlife, and explore Portuguese history in Goa.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Jammu Kashmir',
                'description' => 'Visit the paradise on Earth with scenic mountains, valleys, and beautiful lakes in Jammu & Kashmir.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Karnataka',
                'description' => 'Experience the rich diversity of tech hubs, historical ruins, and natural parks in Karnataka.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Kerala',
                'description' => 'Relax in God\'s Own Country with serene backwaters, houseboats, and lush greenery in Kerala.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Ladakh',
                'description' => 'Adventure through the high-altitude cold deserts, mountain passes, and lakes in Ladakh.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Lakshadweep',
                'description' => 'Explore the beautiful coral reefs, azure waters, and white sand beaches in Lakshadweep.',
                'image' => null,
                'status' => true
            ],
            [
                'name' => 'Tamilnadu',
                'description' => 'Discover the ancient temples, rich Dravidian history, and coastal beauty of Tamil Nadu.',
                'image' => null,
                'status' => true
            ]
        ];

        foreach ($destinations as $dest) {
            Destination::updateOrCreate(
                ['slug' => Str::slug($dest['name'])],
                [
                    'name' => $dest['name'],
                    'description' => $dest['description'],
                    'image' => $dest['image'],
                    'status' => $dest['status']
                ]
            );
        }

        // 2. Seed Trip Types (20 items)
        $tripTypes = [
            'Adventure Cruises',
            'Adventure Tours',
            'Beach Holidays',
            'Budget Travel',
            'Child-friendly Tours',
            'Cultural Tours',
            'Customizable Tours',
            'Family Vacations',
            'Group Tours',
            'Heritage Tours',
            'Hills-stations',
            'Honeymoon & Romantic Getaways',
            'Jungle adventures',
            'Nature Friendly',
            'Pilgrimage Tours',
            'Seasonal Trips',
            'Water Sports Adventures',
            'Weekend Trips',
            'Wellness & Spa Retreats',
            'Wildlife & Nature'
        ];

        foreach ($tripTypes as $type) {
            TripType::updateOrCreate(
                ['slug' => Str::slug($type)],
                [
                    'name' => $type,
                    'description' => 'Curated packages for ' . $type . ' experience.',
                    'icon' => null,
                    'image' => null,
                    'status' => true
                ]
            );
        }

        // 3. Seed Activities (35 items)
        $activities = [
            'Amusement Rides' => 'Thrilling amusement park rides and attractions for families.',
            'ATV Ride' => 'Off-road all-terrain vehicle adventures across rugged landscapes.',
            'Beach Relaxation' => 'Unwind on beautiful sandy beaches and soak up the sun.',
            'Bird Watching' => 'Spot rare bird species in their natural wildlife habitats.',
            'Boating' => 'Scenic boat cruises and leisure boat rides on calm waters.',
            'Bonfire Night' => 'Cozy evenings around a warm bonfire with music and storytelling.',
            'Bungee Jumping' => 'Exhilarating freefall jumps from high platforms for thrill-seekers.',
            'Camping' => 'Sleep under the stars at scenic mountain and forest campsites.',
            'Cultural & Tribal Experiences' => 'Immersive tours exploring local tribal traditions and heritage.',
            'Elephant Safari' => 'A unique safari experience riding elephants through natural reserves.',
            'Farm Tour' => 'Guided farm walks with local organic produce harvesting.',
            'Fishing & Angling' => 'Relaxing fishing expeditions in lakes, rivers, and deep seas.',
            'Folk Dance Performance' => 'Traditional regional folk dance shows and cultural performances.',
            'Heritage Walk' => 'Guided historical walks exploring architecture and monuments.',
            'Houseboat Stay' => 'Overnight stays in traditional floating houseboats on the backwaters.',
            'Jet Skiing' => 'High-speed jet ski rides across lakes and open seas.',
            'Jungle Safari' => 'Thrilling wildlife safari tours inside national parks.',
            'Museum Tour' => 'Explore historic archives, art, and ancient artifacts in museums.',
            'Nature Trail' => 'Scenic hiking trails and guided nature walks through forests.',
            'Off-roading' => '4x4 vehicle driving adventures through extreme terrains.',
            'Parasailing' => 'Fly high above the ocean while towed by a speed boat.',
            'River Rafting' => 'Navigate rapid river waves in whitewater rafting tours.',
            'Rock Climbing' => 'Challenging rock climbing and bouldering activities.',
            'Scuba Diving' => 'Explore the magical underwater marine life and coral reefs.',
            'Sea Kayaking' => 'Leisurely kayak paddling along coastlines and through lagoons.',
            'Shikara Ride' => 'Tranquil rides in traditional wooden boats on famous lakes.',
            'Snorkeling' => 'Swim with exotic fishes and explore shallow coral beds.',
            'Spa & Wellness Treatments' => 'Rejuvenating massage and wellness therapies at luxury spas.',
            'Star Gazing' => 'Clear night sky viewing of stars and constellations.',
            'Sunrise Viewing' => 'Early morning tours to catch the beautiful mountain sunrises.',
            'Temple Visit' => 'Explore sacred shrines, historic temples, and architectures.',
            'Theme Park Visit' => 'Fun-filled day trips to major adventure theme parks.',
            'Trekking' => 'Hiking expeditions up scenic peaks and challenging valleys.',
            'Yoga & Meditation' => 'Holistic yoga classes and meditation sessions in nature.',
            'Zip Lining' => 'Glide down steel cables high above valleys and forests.'
        ];

        foreach ($activities as $name => $desc) {
            Activity::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $desc,
                    'image' => null,
                    'status' => true
                ]
            );
        }
    }
}
