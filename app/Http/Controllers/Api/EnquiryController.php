<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    /**
     * Store a customer package enquiry.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data from the customer form
        $validated = $request->validate([
            'package_id' => 'nullable|exists:packages,id',
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'required|string|max:20',
            'message'    => 'nullable|string',
        ]);

        // 2. Create the enquiry record
        $enquiry = Enquiry::create([
            'package_id' => $validated['package_id'] ?? null,
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'message'    => $validated['message'],
            'status'     => 'new' // Defaults to new as specified in migrations
        ]);

        // 3. Send Email Notification
        $packageName = $enquiry->package ? $enquiry->package->title : 'General Enquiry';
        $emailContent = "New holiday inquiry received!\n\n" .
            "Name: {$enquiry->name}\n" .
            "Email: {$enquiry->email}\n" .
            "Phone: {$enquiry->phone}\n" .
            "Tour Package: {$packageName}\n" .
            "Message:\n{$enquiry->message}\n";

        try {
            Mail::raw($emailContent, function ($message) use ($enquiry, $packageName) {
                $message->to(config('mail.from.address') ?: 'admin@sg-holidays.com')
                    ->subject("New Enquiry: " . $packageName);
            });
        } catch (\Exception $e) {
            // Log warning but don't fail the request
            logger()->warning("Failed to send enquiry email: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your holiday inquiry has been submitted successfully. Our team will contact you soon.',
            'data'    => $enquiry
        ], 201);
    }
}
