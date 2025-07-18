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
        'gender' => 'nullable|string|max:18',
        'date_of_birth' => 'nullable|date',
        'role' => 'required|string|max:100',
    ]);

    $employee = Employee::create($validated);

    return response()->json([
        'message' => 'Employee added successfully',
        'employee' => $employee
    ], 201);
})->name('store.employee');

// routes/api.php
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'index']);

    // Update an event
    Route::put('/events/{id}', function (Request $request, $id) {
        $fields = [
            'title' => 'string|max:255',
            'description' => 'string',
            'location' => 'string',
            'start_time' => 'date',
            'end_time' => 'date|after_or_equal:start_time',
        ];
    
        // Remove null values (fields not actually sent)
        $input = array_filter(
            $request->only(array_keys($fields)),
            fn ($value) => !is_null($value)
        );
    
        if (empty($input)) {
            return response()->json([
                'message' => 'At least one field must be provided for update.'
            ], 422);
        }
    
        $validated = validator($input, array_intersect_key($fields, $input))->validate();
    
        $event = Events::find($id);
        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
        
        $event->update($validated);
    
        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    })->middleware(ApiMiddleware::class)->name('update.event');
   
   
    // Delete an event
    Route::delete('/events/{id}', function ($id) {
        $event = Events::find($id);
        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ]);
    })->middleware(ApiMiddleware::class)->name('delete.event');

  

  
    Route::post('/register', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:11',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        // First, create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);
    
        // Then generate the JWT token
        $token = Auth::guard('api')->login($user);
        // Store the token in the personal_token column
        $user->personal_token = $token;
        $user->save();
    
        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user
        ]);
    });




    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Find user by email
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }
    
        // Attempt login via JWT and generate a new token
        $token = Auth::guard('api')->login($user);
    
        // Save token in personal_token column
        $user->personal_token = $token;
        $user->save();
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    });