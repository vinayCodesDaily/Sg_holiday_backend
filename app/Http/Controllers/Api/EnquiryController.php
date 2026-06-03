<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Store a customer package enquiry.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data from the customer form
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'required|string|max:20',
            'message'    => 'nullable|string',
        ]);

        // 2. Create the enquiry record
        $enquiry = Enquiry::create([
            'package_id' => $validated['package_id'],
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'message'    => $validated['message'],
            'status'     => 'new' // Defaults to new as specified in migrations
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your holiday inquiry has been submitted successfully. Our team will contact you soon.',
            'data'    => $enquiry
        ], 201);
    }
}
