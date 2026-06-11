<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AdminEnquiryNotification;
use App\Mail\CustomerEnquiryThankYou;
use App\Models\Enquiry;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'nullable|exists:packages,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'destination' => 'nullable|string|max:255',
            'travel_date' => 'nullable|date',
            'number_of_persons' => 'nullable|integer|min:1|max:100',
            'message' => 'nullable|string',
        ]);

        $package = null;
        if (!empty($validated['package_id'])) {
            $package = Package::with('destination')->find($validated['package_id']);
        }

        $destination = $validated['destination']
            ?? $package?->destination?->name
            ?? null;

        $enquiry = Enquiry::create([
            'package_id' => $validated['package_id'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'],
            'destination' => $destination,
            'travel_date' => $validated['travel_date'] ?? null,
            'number_of_persons' => $validated['number_of_persons'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        $enquiry->load(['package.destination']);

        $adminEmails = User::adminNotificationEmails();

        try {
            if (!empty($adminEmails)) {
                Mail::to($adminEmails)->send(new AdminEnquiryNotification($enquiry));
            }
        } catch (\Exception $e) {
            logger()->warning('Failed to send admin enquiry email: ' . $e->getMessage());
        }

        try {
            if (!empty($enquiry->email)) {
                Mail::to($enquiry->email)->send(new CustomerEnquiryThankYou($enquiry));
            }
        } catch (\Exception $e) {
            logger()->warning('Failed to send customer enquiry thank-you email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your holiday inquiry has been submitted successfully. Our team will contact you soon.',
            'data' => $enquiry,
        ], 201);
    }
}
