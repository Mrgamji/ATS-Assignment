<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklyAttendanceLog;

class WeeklyAttendanceLogController extends Controller
{
    // List all weekly attendance logs
    public function index()
    {
        return response()->json(WeeklyAttendanceLog::all(), 200);
    }

    // Store a new weekly attendance log
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'week' => 'required|integer|min:1|max:53',
            'year' => 'required|integer|min:2000',
            'total_minutes' => 'required|integer|min:0',
        ]);

        $log = WeeklyAttendanceLog::create($validated);
        return response()->json($log, 201);
    }

    // Show a single weekly attendance log
    public function show($id)
    {
        $log = WeeklyAttendanceLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Weekly attendance log not found'], 404);
        }
        return response()->json($log);
    }

    // Update a weekly attendance log
    public function update(Request $request, $id)
    {
        $log = WeeklyAttendanceLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Weekly attendance log not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'week' => 'sometimes|integer|min:1|max:53',
            'year' => 'sometimes|integer|min:2000',
            'total_minutes' => 'sometimes|integer|min:0',
        ]);

        $log->update($validated);
        return response()->json($log);
    }

    // Delete a weekly attendance log
    public function destroy($id)
    {
        $log = WeeklyAttendanceLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Weekly attendance log not found'], 404);
        }

        $log->delete();
        return response()->json(['message' => 'Weekly attendance log deleted successfully']);
    }
}