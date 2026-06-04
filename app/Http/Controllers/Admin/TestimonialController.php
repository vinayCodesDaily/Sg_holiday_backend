<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    // PUBLIC + ADMIN LIST (you can filter via status)
    public function index(Request $request)
    {
        $query = Testimonial::query();

        // If NOT admin route → show only active testimonials
        if (!$request->is('api/admin/*')) {
            $query->where('status', 1);
        }

        return response()->json($query->latest()->get());
    }

    // STORE (ADMIN ONLY)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial = Testimonial::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'message' => $request->message,
            'rating' => $request->rating,
            'image' => $imagePath,
            'status' => $request->status ?? 1,
        ]);

        return response()->json([
            'message' => 'Testimonial created successfully',
            'data' => $testimonial
        ]);
    }

    // UPDATE (ADMIN ONLY)
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($request->hasFile('image')) {
            $testimonial->image = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($request->only([
            'name',
            'designation',
            'message',
            'rating',
            'status'
        ]));

        return response()->json([
            'message' => 'Testimonial updated successfully',
            'data' => $testimonial
        ]);
    }

    // DELETE (ADMIN ONLY)
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return response()->json([
            'message' => 'Testimonial deleted successfully'
        ]);
    }
}