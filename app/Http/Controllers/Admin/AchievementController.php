<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Achievement::orderBy('display_order')->get()
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Achievement::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
            'type' => 'required|string'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request
                ->file('image')
                ->store('achievements', 'public');
        }

        $achievement = Achievement::create([
            'title' => $request->title,
            'image' => $imagePath,
            'type' => $request->type,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status ?? true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Achievement created successfully',
            'data' => $achievement
        ]);
    }

    public function update(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string'
        ]);

        $imagePath = $achievement->image;

        if ($request->hasFile('image')) {

            if (
                $achievement->image &&
                Storage::disk('public')->exists($achievement->image)
            ) {
                Storage::disk('public')->delete($achievement->image);
            }

            $imagePath = $request
                ->file('image')
                ->store('achievements', 'public');
        }

        $achievement->update([
            'title' => $request->title,
            'image' => $imagePath,
            'type' => $request->type,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status ?? true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Achievement updated successfully',
            'data' => $achievement
        ]);
    }

    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);

        if (
            $achievement->image &&
            Storage::disk('public')->exists($achievement->image)
        ) {
            Storage::disk('public')->delete($achievement->image);
        }

        $achievement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Achievement deleted successfully'
        ]);
    }
}