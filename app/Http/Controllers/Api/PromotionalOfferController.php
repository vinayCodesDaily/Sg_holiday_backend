<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PromotionalOffer;
use Carbon\Carbon;

class PromotionalOfferController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $offers = PromotionalOffer::where('is_active', true)
            ->where(function ($query) use ($today) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $today);
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $offers
        ]);
    }
}