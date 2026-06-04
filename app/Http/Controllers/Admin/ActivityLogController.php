<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    // GET ALL LOGS
    public function index()
    {
        return ActivityLog::latest()->get();
    }

    // GET SINGLE LOG
    public function show($id)
    {
        return ActivityLog::findOrFail($id);
    }

    // DELETE LOG (optional cleanup)
    public function destroy($id)
    {
        ActivityLog::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Log deleted successfully'
        ]);
    }
}
