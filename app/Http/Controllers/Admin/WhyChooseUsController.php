<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhyChooseUs;

class WhyChooseUsController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => WhyChooseUs::orderBy('display_order')->get()
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => WhyChooseUs::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $item = WhyChooseUs::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status ?? true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = WhyChooseUs::findOrFail($id);

        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'display_order' => $request->display_order,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Record updated successfully',
            'data' => $item
        ]);
    }

    public function destroy($id)
    {
        WhyChooseUs::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record deleted successfully'
        ]);
    }
}

