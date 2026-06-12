<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Banner;
use App\Models\TripType;
use App\Models\Package;
use App\Models\HomeAbout;
use App\Models\MonthlyDestination;
use App\Models\WhyChooseUs;
use App\Models\Achievement;
use App\Models\Testimonial;
use App\Models\Statistic;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,

            'data' => [

                'banners' => Banner::where('status',1)->get(),

                'trip_types' => TripType::where('status',1)
                    ->where('is_featured', 1)
                    ->orderBy('id')
                    ->get(),

                'home_about' => HomeAbout::first(),

                'featured_packages' => Package::where('status',1)
                    ->latest()
                    ->take(6)
                    ->get(),

                'monthly_destinations' => MonthlyDestination::where('status',1)
                    ->orderBy('id')
                    ->get()
                    ->groupBy('month'),

                'why_choose_us' => WhyChooseUs::where('status',1)
                    ->orderBy('id')
                    ->get(),

                'achievements' => Achievement::where('status',1)
                    ->orderBy('id')
                    ->get(),

                'testimonials' => Testimonial::where('status',1)
                    ->latest()
                    ->get(),

                'statistics' => Statistic::where('status',1)
                    ->orderBy('id')
                    ->get()
            ]
        ]);
    }
}