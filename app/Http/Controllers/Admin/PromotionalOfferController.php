<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionalOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionalOfferController extends Controller
{
    public function index()
    {
        $offers = PromotionalOffer::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $offers
        ]);
    }

    public function show($id)
    {
        $offer = PromotionalOffer::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $offer
        ]);
    }

    private function validationRules($id = null)
    {
        return [
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'badge'       => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'is_active'   => 'nullable|boolean',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->validationRules()
        );

        try {

            $image = null;

            if ($request->hasFile('image')) {
                $image = $request
                    ->file('image')
                    ->store('promotional-offers', 'public');
            }

            $offer = PromotionalOffer::create([
                'title'       => $validated['title'],
                'subtitle'    => $validated['subtitle'] ?? null,
                'image'       => $image,
                'badge'       => $validated['badge'] ?? null,
                'button_text' => $validated['button_text'] ?? null,
                'button_link' => $validated['button_link'] ?? null,
                'start_date'  => $validated['start_date'] ?? null,
                'end_date'    => $validated['end_date'] ?? null,
                'is_active'   => $request->boolean('is_active', true),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Promotional offer created successfully.',
                'data'    => $offer
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $offer = PromotionalOffer::findOrFail($id);

        $validated = $request->validate(
            $this->validationRules($offer->id)
        );

        try {

            if ($request->hasFile('image')) {

                if ($offer->image) {
                    Storage::disk('public')
                        ->delete($offer->image);
                }

                $offer->image = $request
                    ->file('image')
                    ->store('promotional-offers', 'public');
            }

            $offer->update([
                'title'       => $validated['title'],
                'subtitle'    => $validated['subtitle'] ?? null,
                'image'       => $offer->image,
                'badge'       => $validated['badge'] ?? null,
                'button_text' => $validated['button_text'] ?? null,
                'button_link' => $validated['button_link'] ?? null,
                'start_date'  => $validated['start_date'] ?? null,
                'end_date'    => $validated['end_date'] ?? null,
                'is_active'   => $request->boolean('is_active', true),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Promotional offer updated successfully.',
                'data'    => $offer
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $offer = PromotionalOffer::findOrFail($id);

        try {

            if ($offer->image) {
                Storage::disk('public')
                    ->delete($offer->image);
            }

            $offer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Promotional offer deleted successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        $offer = PromotionalOffer::findOrFail($id);

        $offer->update([
            'is_active' => !$offer->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'data'    => $offer
        ]);
    }
}