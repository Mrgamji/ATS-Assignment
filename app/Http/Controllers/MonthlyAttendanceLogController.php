<?php

namespace App\Http\Controllers;

use App\Models\MonthlyAttendanceLog;
use Illuminate\Http\Request;

class MonthlyAttendanceLogController extends Controller
{
    // List all monthly attendance logs
    public function index()
    {
        return response()->json(MonthlyAttendanceLog::all(), 200);
    }

    // Store a new monthly attendance log
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
            'total_minutes' => 'required|integer|min:0',
        ]);

        $log = MonthlyAttendanceLog::create($validated);
        return response()->json($log, 201);
    }

    // Show a single monthly attendance log
    public function show($id)
    {
        $log = MonthlyAttendanceLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Monthly attendance log not found'], 404);
        }
        return response()->json($log);
    }

    // Update a monthly attendance log
    public function update(Request $request, $id)
    {
        $log = MonthlyAttendanceLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Monthly attendance log not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'month' => 'sometimes|integer|min:1|max:12',
            'year' => 'sometimes|integer|min:2000',
            'total_minutes' => 'sometimes|integer|min:0',
        ]);

        $log->update($validated);
        return response()->json($log);
    }

    // Delete a monthly attendance log
    public function destroy($id)
    {
        $log = MonthlyAttendanceLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Monthly attendance log not found'], 404);
        }

        $log->delete();
        return response()->json(['message' => 'Monthly attendance log deleted successfully']);
    }
}