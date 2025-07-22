<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'designation' => 'required|string',
            'department' => 'required|string',
            'employment_type' => 'required|string',
            'date_of_joining' => 'required|date',
            'employee_code' => 'required|string|unique:employees,employee_code',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'role' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employee_photos', 'public');
        }

        $employee = Employee::create($validated);

        return response()->json(['success' => true, 'employee' => $employee], 201);
    }
}
