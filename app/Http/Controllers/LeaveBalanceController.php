<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveBalance;

class LeaveBalanceController extends Controller
{
    // Display a listing of leave balances
    public function index()
    {
        return response()->json(LeaveBalance::all(), 200);
    }

    // Store a newly created leave balance
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'total_entitled' => 'required|integer|min:0',
            'used' => 'nullable|integer|min:0',
            'remaining' => 'nullable|integer|min:0',
        ]);

        $leaveBalance = LeaveBalance::create($validated);

        return response()->json($leaveBalance, 201);
    }

    // Display the specified leave balance
    public function show($id)
    {
        $leaveBalance = LeaveBalance::find($id);
        if (!$leaveBalance) {
            return response()->json(['message' => 'Leave balance not found'], 404);
        }
        return response()->json($leaveBalance);
    }

    // Update the specified leave balance
    public function update(Request $request, $id)
    {
        $leaveBalance = LeaveBalance::find($id);
        if (!$leaveBalance) {
            return response()->json(['message' => 'Leave balance not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'leave_type_id' => 'sometimes|required|exists:leave_types,id',
            'total_entitled' => 'sometimes|required|integer|min:0',
            'used' => 'sometimes|integer|min:0',
            'remaining' => 'sometimes|integer|min:0',
        ]);

        $leaveBalance->update($validated);

        return response()->json($leaveBalance);
    }

    // Remove the specified leave balance
    public function destroy($id)
    {
        $leaveBalance = LeaveBalance::find($id);
        if (!$leaveBalance) {
            return response()->json(['message' => 'Leave balance not found'], 404);
        }
        $leaveBalance->delete();

        return response()->json(['message' => 'Leave balance deleted successfully']);
    }
}
