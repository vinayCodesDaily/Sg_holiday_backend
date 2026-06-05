<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyDestination;
use Illuminate\Http\Request;

class MonthlyDestinationController extends Controller
{
    public function index()
    {
        $data = MonthlyDestination::with('package')
            ->orderBy('month')
            ->orderBy('display_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'place_name' => 'required',
            'description' => 'required',
            'package_id' => 'nullable|exists:packages,id'
        ]);

        $destination = MonthlyDestination::create([
            'month' => $request->month,
            'place_name' => $request->place_name,
            'description' => $request->description,
            'package_id' => $request->package_id,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Destination added successfully',
            'data' => $destination
        ]);
    }

    public function show($id)
    {
        $destination = MonthlyDestination::with('package')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $destination
        ]);
    }

    public function update(Request $request, $id)
    {
        $destination = MonthlyDestination::findOrFail($id);

        $request->validate([
            'month' => 'required',
            'place_name' => 'required',
            'description' => 'required',
            'package_id' => 'nullable|exists:packages,id'
        ]);

        $destination->update([
            'month' => $request->month,
            'place_name' => $request->place_name,
            'description' => $request->description,
            'package_id' => $request->package_id,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Destination updated successfully',
            'data' => $destination
        ]);
    }

    public function destroy($id)
    {
        MonthlyDestination::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Destination deleted successfully'
        ]);
    }

    /**
     * Homepage API
     */
    public function groupedByMonth()
    {
        $data = MonthlyDestination::with('package')
            ->where('status', 1)
            ->orderBy('display_order')
            ->get()
            ->groupBy('month');

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}