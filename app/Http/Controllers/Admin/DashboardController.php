<?php

namespace App\Http\Controllers\Admin;
use App\Models\Package;
use App\Models\Enquiry;
use App\Models\Destination;
use App\Models\TripType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    /**
     * Retrieve aggregated statistics for the admin control panel landing layout.
     */
    public function getMetrics()
    {
        try {
            // 1. Core Summary Counter Cards
            $totalPackages     = Package::count();
            $activePackages    = Package::where('status', true)->count();
            $featuredPackages  = Package::where('featured', true)->count();
            $totalDestinations = Destination::count();
            $totalEnquiries    = Enquiry::count();

            // 2. Enquiry Status Breakdown (For distribution pie charts)
            $enquiryStatusCounts = Enquiry::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->pluck('total', 'status')
                ->toArray();

            // Ensure all statuses exist in response map even if count is zero
            $enquiryStats = [
                'new'       => $enquiryStatusCounts['new'] ?? 0,
                'contacted' => $enquiryStatusCounts['contacted'] ?? 0,
                'closed'    => $enquiryStatusCounts['closed'] ?? 0,
            ];

            // 3. Top Performing Hot Destinations (Most packages associated)
            $popularDestinations = Destination::withCount('packages')
                ->orderBy('packages_count', 'desc')
                ->take(5)
                ->get()
                ->map(function ($dest) {
                    return [
                        'name'           => $dest->name,
                        'packages_count' => $dest->packages_count
                    ];
                });

            // 4. Trip Type Breakdown (Volume tracking)
            $tripTypeVolume = TripType::withCount('packages')
                ->orderBy('packages_count', 'desc')
                ->take(5)
                ->get()
                ->map(function ($type) {
                    return [
                        'category'       => $type->name,
                        'packages_count' => $type->packages_count
                    ];
                });

            // 5. Recent Enquiries Feed (Quick desk updates ticker)
            $recentEnquiries = Enquiry::with('package:id,title')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($enq) {
                    return [
                        'id'           => $enq->id,
                        'customer'     => $enq->name,
                        'phone'        => $enq->phone,
                        'package'      => $enq->package ? $enq->package->title : 'General Inquiry',
                        'status'       => $enq->status,
                        'submitted_at' => $enq->created_at->diffForHumans()
                    ];
                });

            return response()->json([
                'success' => true,
                'data'    => [
                    'counters' => [
                        'total_packages'     => $totalPackages,
                        'active_packages'    => $activePackages,
                        'featured_packages'  => $featuredPackages,
                        'total_destinations' => $totalDestinations,
                        'total_enquiries'    => $totalEnquiries,
                    ],
                    'enquiry_distribution'  => $enquiryStats,
                    'popular_destinations'  => $popularDestinations,
                    'trip_type_distribution'=> $tripTypeVolume,
                    'recent_enquiries'      => $recentEnquiries
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate metrics layout data telemetry.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}


