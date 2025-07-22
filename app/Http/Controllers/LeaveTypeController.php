<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    // Display a listing of leave types
    public function index()
    {
        return response()->json(LeaveType::all(), 200);
    }

    // Store a newly created leave type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_days_per_year' => 'required|integer',
            'requires_approval' => 'boolean',
        ]);

        $leaveType = LeaveType::create($validated);

        return response()->json($leaveType, 201);
    }

    // Display the specified leave type
    public function show($id)
    {
        $leaveType = LeaveType::find($id);
        if (!$leaveType) {
            return response()->json(['message' => 'Leave type not found'], 404);
        }
        return response()->json($leaveType);
    }

    // Update the specified leave type
    public function update(Request $request, $id)
    {
        $leaveType = LeaveType::find($id);
        if (!$leaveType) {
            return response()->json(['message' => 'Leave type not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'max_days_per_year' => 'sometimes|required|integer',
            'requires_approval' => 'boolean',
        ]);

        $leaveType->update($validated);

        return response()->json($leaveType);
    }

    // Remove the specified leave type
    public function destroy($id)
    {
        $leaveType = LeaveType::find($id);
        if (!$leaveType) {
            return response()->json(['message' => 'Leave type not found'], 404);
        }
        $leaveType->delete();

        return response()->json(['message' => 'Leave type deleted successfully']);
    }
}
