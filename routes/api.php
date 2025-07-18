<?php

use App\Http\Middleware\ApiMiddleware;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/employees', function () {
    // Example: return all events as JSON
    return \App\Models\Employee::all();
})->name('get.employees');

Route::get('/employees/{id}', function ($id) {
    $employee= Employee::find($id);

    if (!$employee) {
        return response()->json([
            'message' => 'Employee not found'
        ], 404);
    }

    return response()->json([
        'employee' => $employee
    ]);
})->name('get.single.employee');

Route::post('/employee/store', function (Request $request) {
    $validated = $request->validate([
        // Personal Details
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'photo' => 'nullable|string', // URL or path
        'email' => 'required|email|unique:employees,email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'emergency_contact_name' => 'nullable|string|max:255',
        'emergency_contact_phone' => 'nullable|string|max:20',

        // Employment Details
        'designation' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'manager_id' => 'nullable|exists:employees,id',
        'employment_type' => 'required|in:full-time,graduate-trainee,intern,part-time,contract',
        'date_of_joining' => 'nullable|date',
        'employee_code' => 'required|string|unique:employees,employee_code',

        // Other
        'gender' => 'nullable|integer|min:18',
        'date_of_birth' => 'nullable|date',
        'role' => 'required|string|max:100',
    ]);

    $employee = Employee::create($validated);

    return response()->json([
        'message' => 'Employee added successfully',
        'employee' => $employee
    ], 201);
})->name('store.employee');

