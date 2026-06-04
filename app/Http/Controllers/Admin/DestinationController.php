<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Destination::latest()->get()
        ]);
    }

    public function show($id)
    {
        $destination = Destination::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $destination
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|boolean'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request
                ->file('image')
                ->store('destinations', 'public');
        }

        $destination = Destination::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'status' => $request->boolean('status', true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Destination created successfully',
            'data' => $destination
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|boolean'
        ]);

        if ($request->hasFile('image')) {

            if ($destination->image) {
                Storage::disk('public')->delete($destination->image);
            }

            $destination->image = $request
                ->file('image')
                ->store('destinations', 'public');
        }

        $destination->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'image' => $destination->image,
            'status' => $request->boolean('status', true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Destination updated successfully',
            'data' => $destination
        ]);
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);

        if ($destination->image) {
            Storage::disk('public')->delete($destination->image);
        }

        $destination->delete();

        return response()->json([
            'success' => true,
            'message' => 'Destination deleted successfully'
        ]);
    }
}