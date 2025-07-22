<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\AnalyticsLog;

class AnalyticsLogController extends Controller
{
    // Display all analytics logs
    public function index()
    {
        return response()->json(AnalyticsLog::all(), 200);
    }

    // Store a new analytics log
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|string|max:255',
            'generated_by' => 'nullable|exists:employees,id',
            'filters' => 'nullable|json',
            'generated_at' => 'required|date',
        ]);

        $log = AnalyticsLog::create($validated);

        return response()->json($log, 201);
    }

    // Show specific analytics log
    public function show($id)
    {
        $log = AnalyticsLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Analytics log not found'], 404);
        }
        return response()->json($log);
    }

    // Update analytics log
    public function update(Request $request, $id)
    {
        $log = AnalyticsLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Analytics log not found'], 404);
        }

        $validated = $request->validate([
            'report_type' => 'sometimes|string|max:255',
            'generated_by' => 'nullable|exists:employees,id',
            'filters' => 'nullable|json',
            'generated_at' => 'sometimes|date',
        ]);

        $log->update($validated);

        return response()->json($log);
    }

    // Delete analytics log
    public function destroy($id)
    {
        $log = AnalyticsLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Analytics log not found'], 404);
        }

        $log->delete();
        return response()->json(['message' => 'Analytics log deleted successfully']);
    }
}
