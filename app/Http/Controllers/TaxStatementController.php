<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxStatement;

class TaxStatementController extends Controller
{
    // Display a listing of tax statements
    public function index()
    {
        return response()->json(TaxStatement::all(), 200);
    }

    // Store a newly created tax statement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payroll_id' => 'required|exists:payrolls,id',
            'gross_income' => 'required|numeric|min:0',
            'taxable_income' => 'required|numeric|min:0',
            'tax_deducted' => 'required|numeric|min:0',
            'tax_code' => 'nullable|string',
            'statement_date' => 'required|date'
        ]);

        $taxStatement = TaxStatement::create($validated);

        return response()->json($taxStatement, 201);
    }

    // Display the specified tax statement
    public function show($id)
    {
        $taxStatement = TaxStatement::find($id);
        if (!$taxStatement) {
            return response()->json(['message' => 'Tax statement not found'], 404);
        }
        return response()->json($taxStatement);
    }

    // Update the specified tax statement
    public function update(Request $request, $id)
    {
        $taxStatement = TaxStatement::find($id);
        if (!$taxStatement) {
            return response()->json(['message' => 'Tax statement not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'payroll_id' => 'sometimes|required|exists:payrolls,id',
            'gross_income' => 'sometimes|numeric|min:0',
            'taxable_income' => 'sometimes|numeric|min:0',
            'tax_deducted' => 'sometimes|numeric|min:0',
            'tax_code' => 'nullable|string',
            'statement_date' => 'sometimes|required|date'
        ]);

        $taxStatement->update($validated);

        return response()->json($taxStatement);
    }

    // Remove the specified tax statement
    public function destroy($id)
    {
        $taxStatement = TaxStatement::find($id);
        if (!$taxStatement) {
            return response()->json(['message' => 'Tax statement not found'], 404);
        }
        $taxStatement->delete();

        return response()->json(['message' => 'Tax statement deleted successfully']);
    }
}
