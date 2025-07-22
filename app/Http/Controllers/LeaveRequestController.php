<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;

class LeaveRequestController extends Controller
{
    // Display a listing of leave requests
    public function index()
    {
        return response()->json(LeaveRequest::all(), 200);
    }

    // Store a newly created leave request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'status' => 'in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:employees,id',
            'reason' => 'nullable|string',
            'rejection_reason' => 'nullable|string',
        ]);

        $leaveRequest = LeaveRequest::create($validated);

        return response()->json($leaveRequest, 201);
    }

    // Display the specified leave request
    public function show($id)
    {
        $leaveRequest = LeaveRequest::find($id);
        if (!$leaveRequest) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }
        return response()->json($leaveRequest);
    }

    // Update the specified leave request
    public function update(Request $request, $id)
    {
        $leaveRequest = LeaveRequest::find($id);
        if (!$leaveRequest) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'leave_type_id' => 'sometimes|required|exists:leave_types,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'total_days' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:pending,approved,rejected',
            'approved_by' => 'sometimes|nullable|exists:employees,id',
            'reason' => 'sometimes|nullable|string',
            'rejection_reason' => 'sometimes|nullable|string',
        ]);

        $leaveRequest->update($validated);

        return response()->json($leaveRequest);
    }

    // Remove the specified leave request
    public function destroy($id)
    {
        $leaveRequest = LeaveRequest::find($id);
        if (!$leaveRequest) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }
        $leaveRequest->delete();

        return response()->json(['message' => 'Leave request deleted successfully']);
    }
}
