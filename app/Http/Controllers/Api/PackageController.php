<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    // 1. Get all active packages with basic filters (e.g., by destination)
    public function index(Request $request)
    {
        $query = Package::with('destination');

        // Search by package title
        if ($request->filled('search')) {
            $query->where(
                'title',
                'like',
                '%'.$request->search.'%'
            );
        }

        // Filter by destination
        if ($request->filled('destination')) {
            $query->where(
                'destination_id',
                $request->destination
            );
        }

        // Filter featured packages
        if ($request->filled('featured')) {
            $query->where(
                'featured',
                $request->featured
            );
        }

        // Filter duration
        if ($request->filled('duration_days')) {
            $query->where(
                'duration_days',
                $request->duration_days
            );
        }

        // Sort by price
        if ($request->sort == 'price_low') {
            $query->orderBy('starting_price', 'asc');
        }

        if ($request->sort == 'price_high') {
            $query->orderBy('starting_price', 'desc');
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate(12),
        ]);
    }

    // 2. Get a single package detail page with all its nested components
    public function show($slug)
    {
        $package = Package::where('slug', $slug)
            ->where('status', true)
            ->with([
                'destination',
                'tripTypes',
                'images',
                'itineraries',
                'inclusions',
                'exclusions',
                'faqs',
            ])->firstOrFail(); // Returns 404 automatically if slug is wrong

        return response()->json([
            'success' => true,
            'data' => $package,
        ]);
    }
}
