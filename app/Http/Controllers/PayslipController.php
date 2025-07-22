<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payslip;

class PayslipController extends Controller
{
    // Display a listing of payslips
    public function index()
    {
        return response()->json(Payslip::all(), 200);
    }

    // Store a newly created payslip
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payroll_id' => 'required|exists:payrolls,id',
            'employee_id' => 'required|exists:employees,id',
            'total_earnings' => 'required|numeric|min:0',
            'total_deductions' => 'required|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            'remarks' => 'nullable|string'
        ]);

        $payslip = Payslip::create($validated);

        return response()->json($payslip, 201);
    }

    // Display the specified payslip
    public function show($id)
    {
        $payslip = Payslip::find($id);
        if (!$payslip) {
            return response()->json(['message' => 'Payslip not found'], 404);
        }
        return response()->json($payslip);
    }

    // Update the specified payslip
    public function update(Request $request, $id)
    {
        $payslip = Payslip::find($id);
        if (!$payslip) {
            return response()->json(['message' => 'Payslip not found'], 404);
        }

        $validated = $request->validate([
            'payroll_id' => 'sometimes|required|exists:payrolls,id',
            'employee_id' => 'sometimes|required|exists:employees,id',
            'total_earnings' => 'sometimes|numeric|min:0',
            'total_deductions' => 'sometimes|numeric|min:0',
            'net_pay' => 'sometimes|numeric|min:0',
            'remarks' => 'nullable|string'
        ]);

        $payslip->update($validated);

        return response()->json($payslip);
    }

    // Remove the specified payslip
    public function destroy($id)
    {
        $payslip = Payslip::find($id);
        if (!$payslip) {
            return response()->json(['message' => 'Payslip not found'], 404);
        }
        $payslip->delete();

        return response()->json(['message' => 'Payslip deleted successfully']);
    }
}
