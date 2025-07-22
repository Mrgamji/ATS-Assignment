<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // Display all attendance records
    public function index()
    {
        return response()->json(Attendance::all(), 200);
    }

    // Store a new attendance record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i:s',
            'clock_out' => 'nullable|date_format:H:i:s',
            'method' => 'required|in:facial_recognition,biometric,remote',
            'shift_id' => 'nullable|integer',
            'total_hours' => 'nullable|numeric',
            'is_late' => 'boolean',
            'is_absent' => 'boolean',
        ]);

        $attendance = Attendance::create($validated);
        return response()->json($attendance, 201);
    }

    // Show specific attendance record
    public function show($id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }
        return response()->json($attendance);
    }

    // Update attendance record
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'attendance_date' => 'sometimes|date',
            'clock_in' => 'nullable|date_format:H:i:s',
            'clock_out' => 'nullable|date_format:H:i:s',
            'method' => 'sometimes|in:facial_recognition,biometric,remote',
            'shift_id' => 'nullable|integer',
            'total_hours' => 'nullable|numeric',
            'is_late' => 'boolean',
            'is_absent' => 'boolean',
        ]);

        $attendance->update($validated);
        return response()->json($attendance);
    }

    // Delete attendance record
    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }

        $attendance->delete();
        return response()->json(['message' => 'Attendance record deleted successfully']);
    }
}