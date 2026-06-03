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
        $query = Package::where('status', true)->with(['destination', 'tripTypes']);

        if ($request->has('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        $packages = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $packages
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
                'faqs'
            ])->firstOrFail(); // Returns 404 automatically if slug is wrong

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }
}