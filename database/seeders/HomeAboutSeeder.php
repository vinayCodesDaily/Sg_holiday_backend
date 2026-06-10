<?php

namespace Database\Seeders;

use App\Models\HomeAbout;
use Illuminate\Database\Seeder;

class HomeAboutSeeder extends Seeder
{
    public function run(): void
    {
        HomeAbout::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Your Trusted Royal Travel Partner',
                'description' => 'SG Holidays — Sree Gowthamaaditya Holidays & Resorts Pvt. Ltd. — is a Hyderabad-based travel house devoted to bespoke holidays across India and abroad. From honeymoons and family getaways to corporate retreats and adventure circuits, we deliver premium planning, transparent pricing, and round-the-clock guest care.',
                'image' => null,
                'plan_trip_button_text' => 'Plan a Trip',
                'plan_trip_button_link' => '/contact',
                'whatsapp_button_text' => 'Chat on WhatsApp',
                'whatsapp_number' => '+919281111733',
                'status' => true,
            ]
        );
    }
}
