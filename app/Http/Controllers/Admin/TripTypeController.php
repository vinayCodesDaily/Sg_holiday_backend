<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TripTypeController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => TripType::latest()->get()
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => TripType::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:trip_types,name',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        $tripType = TripType::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $request->boolean('status', true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip Type created successfully.',
            'data' => $tripType
        ]);
    }

    public function update(Request $request, $id)
    {
        $tripType = TripType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:trip_types,name,' . $tripType->id,
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        $tripType->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $request->boolean('status', true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip Type updated successfully.',
            'data' => $tripType
        ]);
    }

    public function destroy($id)
    {
        $tripType = TripType::findOrFail($id);

        $tripType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trip Type deleted successfully.'
        ]);
    }
}
