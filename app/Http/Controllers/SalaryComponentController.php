<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryComponent;

class SalaryComponentController extends Controller
{
    // Display a listing of salary components
    public function index()
    {
        return response()->json(SalaryComponent::all(), 200);
    }

    // Store a newly created salary component
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:earning,deduction',
            'is_taxable' => 'boolean',
        ]);

        $salaryComponent = SalaryComponent::create($validated);

        return response()->json($salaryComponent, 201);
    }

    // Display the specified salary component
    public function show($id)
    {
        $salaryComponent = SalaryComponent::find($id);
        if (!$salaryComponent) {
            return response()->json(['message' => 'Salary component not found'], 404);
        }
        return response()->json($salaryComponent);
    }

    // Update the specified salary component
    public function update(Request $request, $id)
    {
        $salaryComponent = SalaryComponent::find($id);
        if (!$salaryComponent) {
            return response()->json(['message' => 'Salary component not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:earning,deduction',
            'is_taxable' => 'boolean',
        ]);

        $salaryComponent->update($validated);

        return response()->json($salaryComponent);
    }

    // Remove the specified salary component
    public function destroy($id)
    {
        $salaryComponent = SalaryComponent::find($id);
        if (!$salaryComponent) {
            return response()->json(['message' => 'Salary component not found'], 404);
        }
        $salaryComponent->delete();

        return response()->json(['message' => 'Salary component deleted successfully']);
    }
}
