<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // Display a listing of employees
    public function index()
    {
        return response()->json(Employee::all(), 200);
    }

    // Store a newly created employee
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:employees,id',
            'employment_type' => 'required|in:full-time,graduate-trainee,intern,part-time,contract',
            'date_of_joining' => 'nullable|date',
            'employee_code' => 'required|string|unique:employees,employee_code',
            'gender' => 'required|string|max:18',
            'date_of_birth' => 'nullable|date',
            'role' => 'required|string|max:100',
        ]);

        $employee = Employee::create($validated);

        return response()->json($employee, 201);
    }

    // Display the specified employee
    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    // Update the specified employee
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'photo' => 'nullable|string',
            'email' => 'sometimes|required|email|unique:employees,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'designation' => 'sometimes|required|string|max:255',
            'department' => 'sometimes|required|string|max:255',
            'manager_id' => 'nullable|exists:employees,id',
            'employment_type' => 'sometimes|required|in:full-time,graduate-trainee,intern,part-time,contract',
            'date_of_joining' => 'nullable|date',
            'employee_code' => 'sometimes|required|string|unique:employees,employee_code,' . $id,
            'gender' => 'sometimes|required|string|max:18',
            'date_of_birth' => 'nullable|date',
            'role' => 'sometimes|required|string|max:100',
        ]);

        $employee->update($validated);

        return response()->json($employee);
    }

    // Remove the specified employee
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
