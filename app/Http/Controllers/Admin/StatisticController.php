<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        return response()->json(
            Statistic::orderBy('display_order')->get()
        );
    }

    public function store(Request $request)
    {
        $statistic = Statistic::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $statistic
        ]);
    }

    public function show($id)
    {
        return Statistic::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $statistic = Statistic::findOrFail($id);

        $statistic->update($request->all());

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