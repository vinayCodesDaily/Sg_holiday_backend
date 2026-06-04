<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function show()
    {
        $setting = Setting::first();

        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',

            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',

            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        if ($request->hasFile('logo')) {

            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $setting->logo = $request
                ->file('logo')
                ->store('settings/logo', 'public');
        }

        $setting->company_name = $validated['company_name'] ?? null;
        $setting->email = $validated['email'] ?? null;
        $setting->phone = $validated['phone'] ?? null;
        $setting->address = $validated['address'] ?? null;

        $setting->facebook = $validated['facebook'] ?? null;
        $setting->instagram = $validated['instagram'] ?? null;
        $setting->youtube = $validated['youtube'] ?? null;

        $setting->seo_title = $validated['seo_title'] ?? null;
        $setting->seo_description = $validated['seo_description'] ?? null;

        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
            'data' => $setting
        ]);
    }
}