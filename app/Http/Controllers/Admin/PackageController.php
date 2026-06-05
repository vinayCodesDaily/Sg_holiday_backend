<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageImage;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
{
    $packages = Package::with([
        'destination',
        'tripTypes'
    ])->latest()->get();

    return response()->json([
        'success' => true,
        'data' => $packages
    ]);
}
public function show($id)
{
    $package = Package::with([
        'destination',
        'tripTypes',
        'images',
        'itineraries',
        'inclusions',
        'exclusions',
        'faqs'
    ])->findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => $package
    ]);
}
private function validationRules($id = null)
{
    return [
        'destination_id' => 'required|exists:destinations,id',

        'title' => 'required|string|max:255|unique:packages,title,' . $id,

        'short_description' => 'nullable|string',
        'description' => 'nullable|string',

        'duration_days' => 'required|integer|min:0',
        'duration_nights' => 'required|integer|min:0',

        'starting_price' => 'nullable|numeric|min:0',

        'featured' => 'nullable|boolean',
        'status' => 'nullable|boolean',

        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        'trip_types' => 'required|array',
        'trip_types.*' => 'exists:trip_types,id',

        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

        'itineraries' => 'nullable|array',
        'itineraries.*.day_number' => 'required|integer|min:1',
        'itineraries.*.title' => 'required|string|max:255',
        'itineraries.*.description' => 'required|string',

        'inclusions' => 'nullable|array',
        'inclusions.*' => 'string|max:255',

        'exclusions' => 'nullable|array',
        'exclusions.*' => 'string|max:255',

        'faqs' => 'nullable|array',
        'faqs.*.question' => 'required|string|max:255',
        'faqs.*.answer' => 'required|string',
    ];
}
public function store(Request $request)
{
    $validated = $request->validate(
        $this->validationRules()
    );

    DB::beginTransaction();

    try {$thumbnail = null;

if ($request->hasFile('thumbnail')) {
    $thumbnail = $request
        ->file('thumbnail')
        ->store('packages/thumbnails', 'public');
}$package = Package::create([
    'destination_id' => $validated['destination_id'],
    'created_by' => auth()->id(),

    'title' => $validated['title'],
    'slug' => Str::slug($validated['title']),

    'short_description' => $validated['short_description'] ?? null,
    'description' => $validated['description'] ?? null,

    'duration_days' => $validated['duration_days'],
    'duration_nights' => $validated['duration_nights'],

    'starting_price' => $validated['starting_price'] ?? 0,

    'thumbnail' => $thumbnail,

    'featured' => $request->boolean('featured'),
    'status' => $request->boolean('status', true),
]);
$package->tripTypes()
        ->attach($validated['trip_types']);
        if ($request->hasFile('images')) {

    foreach ($request->file('images') as $index => $image) {

        $path = $image->store(
            'packages/gallery',
            'public'
        );

        $package->images()->create([
            'image' => $path,
            'sort_order' => $index
        ]);
    }
}
foreach ($request->itineraries ?? [] as $item) {

    $package->itineraries()->create([
        'day_number' => $item['day_number'],
        'title' => $item['title'],
        'description' => $item['description'],
    ]);
}
foreach ($request->inclusions ?? [] as $item) {

    $package->inclusions()->create([
        'item' => $item
    ]);
}
foreach ($request->exclusions ?? [] as $item) {

    $package->exclusions()->create([
        'item' => $item
    ]);
}
foreach ($request->faqs ?? [] as $faq) {

    $package->faqs()->create([
        'question' => $faq['question'],
        'answer' => $faq['answer']
    ]);
}
DB::commit();

return response()->json([
    'success' => true,
    'message' => 'Package created successfully.',
    'data' => $package->load([
        'destination',
        'tripTypes'
    ])
], 201);
} catch (\Exception $e) {

    DB::rollBack();

    return response()->json([
        'success' => false,
        'message' => $e->getMessage()
    ], 500);
}
}
public function update(Request $request, $id)
{
    $package = Package::findOrFail($id);

    $validated = $request->validate(
        $this->validationRules($package->id)
    );

    DB::beginTransaction();

    try {

        if ($request->hasFile('thumbnail')) {

            if ($package->thumbnail) {
                Storage::disk('public')
                    ->delete($package->thumbnail);
            }

            $package->thumbnail =
                $request->file('thumbnail')
                    ->store('packages/thumbnails', 'public');
        }

        $package->update([
            'destination_id' => $validated['destination_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'duration_days' => $validated['duration_days'],
            'duration_nights' => $validated['duration_nights'],
            'starting_price' => $validated['starting_price'] ?? 0,
            'thumbnail' => $package->thumbnail,
            'featured' => $request->boolean('featured'),
            'status' => $request->boolean('status', true),
        ]);

        $package->tripTypes()
            ->sync($validated['trip_types']);

        $package->itineraries()->delete();
        $package->inclusions()->delete();
        $package->exclusions()->delete();
        $package->faqs()->delete();

        foreach ($request->itineraries ?? [] as $item) {

            $package->itineraries()->create([
                'day_number' => $item['day_number'],
                'title' => $item['title'],
                'description' => $item['description'],
            ]);
        }

        foreach ($request->inclusions ?? [] as $item) {

            $package->inclusions()->create([
                'item' => $item
            ]);
        }

        foreach ($request->exclusions ?? [] as $item) {

            $package->exclusions()->create([
                'item' => $item
            ]);
        }

        foreach ($request->faqs ?? [] as $faq) {

            $package->faqs()->create([
                'question' => $faq['question'],
                'answer' => $faq['answer']
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Package updated successfully.',
            'data' => $package->load([
                'destination',
                'tripTypes'
            ])
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function destroy($id)
{
    $package = Package::with('images')
        ->findOrFail($id);

    DB::beginTransaction();

    try {

        if ($package->thumbnail) {

            Storage::disk('public')
                ->delete($package->thumbnail);
        }

        foreach ($package->images as $image) {

            Storage::disk('public')
                ->delete($image->image);
        }

        $package->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Package deleted successfully.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function listEnquiries()
{
    $enquiries = Enquiry::with('package:id,title')
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $enquiries
    ]);
}
public function updateEnquiryStatus(Request $request,$id) {
    $validated = $request->validate([
    'status' => 'required|in:new,in_progress,resolved,closed',
    'remarks' => 'nullable|string'
]);

    $enquiry = Enquiry::findOrFail($id);

    $enquiry->update([
    'status' => $validated['status'],
    'remarks' => $validated['remarks'] ?? null
]);

    return response()->json([
        'success' => true,
        'message' => 'Status updated.',
        'data' => $enquiry
    ]);
}
}