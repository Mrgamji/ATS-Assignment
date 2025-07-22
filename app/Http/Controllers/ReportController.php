<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    // Display all reports
    public function index()
    {
        return response()->json(Report::all(), 200);
    }

    // Store a new report
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:hr,manager,leadership',
            'data' => 'required|json',
            'created_by' => 'nullable|exists:employees,id',
        ]);

        $report = Report::create($validated);

        return response()->json($report, 201);
    }

    // Show specific report
    public function show($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }
        return response()->json($report);
    }

    // Update report
    public function update(Request $request, $id)
    {
        $report = Report::find($id);
        if (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'sometimes|in:hr,manager,leadership',
            'data' => 'sometimes|json',
            'created_by' => 'nullable|exists:employees,id',
        ]);

        $report->update($validated);

        return response()->json($report);
    }

    // Delete report
    public function destroy($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        $report->delete();
        return response()->json(['message' => 'Report deleted successfully']);
    }
}
