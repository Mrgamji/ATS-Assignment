<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeSalary;

class EmployeeSalaryController extends Controller
{
    // Display a listing of employee salaries
    public function index()
    {
        return response()->json(EmployeeSalary::all(), 200);
    }

    // Store a newly created employee salary
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'component_id' => 'required|exists:salary_components,id',
            'amount' => 'required|numeric|min:0'
        ]);

        $employeeSalary = EmployeeSalary::create($validated);

        return response()->json($employeeSalary, 201);
    }

    // Display the specified employee salary
    public function show($id)
    {
        $employeeSalary = EmployeeSalary::find($id);
        if (!$employeeSalary) {
            return response()->json(['message' => 'Employee salary not found'], 404);
        }
        return response()->json($employeeSalary);
    }

    // Update the specified employee salary
    public function update(Request $request, $id)
    {
        $employeeSalary = EmployeeSalary::find($id);
        if (!$employeeSalary) {
            return response()->json(['message' => 'Employee salary not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'component_id' => 'sometimes|required|exists:salary_components,id',
            'amount' => 'sometimes|numeric|min:0'
        ]);

        $employeeSalary->update($validated);

        return response()->json($employeeSalary);
    }

    // Remove the specified employee salary
    public function destroy($id)
    {
        $employeeSalary = EmployeeSalary::find($id);
        if (!$employeeSalary) {
            return response()->json(['message' => 'Employee salary not found'], 404);
        }
        $employeeSalary->delete();

        return response()->json(['message' => 'Employee salary deleted successfully']);
    }
}
