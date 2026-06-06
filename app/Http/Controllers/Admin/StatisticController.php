<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Statistic::orderBy('display_order')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $statistic = Statistic::create([
            'label'         => $request->label,
            'value'         => $request->value,
            'icon'          => $request->icon,
            'display_order' => $request->display_order ?? 0,
            'status'        => $request->boolean('status', true),
        ]);

        return response()->json([
            'success' => true,
            'data' => $statistic
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data'    => Statistic::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $statistic = Statistic::findOrFail($id);

        $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $statistic->update([
            'label'         => $request->label,
            'value'         => $request->value,
            'icon'          => $request->icon,
            'display_order' => $request->display_order ?? $statistic->display_order,
            'status'        => $request->boolean('status', $statistic->status),
        ]);

        return response()->json([
            'success' => true,
            'data' => $statistic
        ]);
    }

    public function destroy($id)
    {
        Statistic::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted Successfully'
        ]);
    }
}