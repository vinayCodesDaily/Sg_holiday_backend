<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeAboutController extends Controller
{
    public function show()
    {
        return response()->json([
            'success' => true,
            'data' => HomeAbout::first()
        ]);
    }

    public function update(Request $request)
    {
        $record = HomeAbout::first();

        if (!$record) {
            $record = new HomeAbout();
        }

        $imagePath = $record->image;

        if ($request->hasFile('image')) {

            if (
                $record->image &&
                Storage::disk('public')->exists($record->image)
            ) {
                Storage::disk('public')->delete($record->image);
            }

            $imagePath = $request
                ->file('image')
                ->store('home-about', 'public');
        }

        $record->fill([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'plan_trip_button_text' => $request->plan_trip_button_text,
            'plan_trip_button_link' => $request->plan_trip_button_link,
            'whatsapp_button_text' => $request->whatsapp_button_text,
            'whatsapp_number' => $request->whatsapp_number,
            'status' => $request->status ?? true
        ]);

        $record->save();

        return response()->json([
            'success' => true,
            'message' => 'Home About updated successfully',
            'data' => $record
        ]);
    }
}