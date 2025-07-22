<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;

class PayrollController extends Controller
{
    // Display a listing of payrolls
    public function index()
    {
        return response()->json(Payroll::all(), 200);
    }

    // Store a newly created payroll
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payroll_month' => 'required|string',
            'status' => 'in:pending,processed,paid'
        ]);

        $payroll = Payroll::create($validated);

        return response()->json($payroll, 201);
    }

    // Display the specified payroll
    public function show($id)
    {
        $payroll = Payroll::find($id);
        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found'], 404);
        }
        return response()->json($payroll);
    }

    // Update the specified payroll
    public function update(Request $request, $id)
    {
        $payroll = Payroll::find($id);
        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found'], 404);
        }

        $validated = $request->validate([
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'payroll_month' => 'sometimes|required|string',
            'status' => 'in:pending,processed,paid'
        ]);

        $payroll->update($validated);

        return response()->json($payroll);
    }

    // Remove the specified payroll
    public function destroy($id)
    {
        $payroll = Payroll::find($id);
        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found'], 404);
        }
        $payroll->delete();

        return response()->json(['message' => 'Payroll deleted successfully']);
    }
}
