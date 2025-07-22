<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseAssignment;

class CourseAssignmentController extends Controller
{
    // Display all course assignments
    public function index()
    {
        return response()->json(CourseAssignment::all(), 200);
    }

    // Store new course assignment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:assigned,in_progress,completed',
            'assigned_at' => 'required|date',
            'completed_at' => 'nullable|date',
        ]);

        $assignment = CourseAssignment::create($validated);

        return response()->json($assignment, 201);
    }

    // Show specific course assignment
    public function show($id)
    {
        $assignment = CourseAssignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'Course assignment not found'], 404);
        }
        return response()->json($assignment);
    }

    // Update course assignment
    public function update(Request $request, $id)
    {
        $assignment = CourseAssignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'Course assignment not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'course_id' => 'sometimes|exists:courses,id',
            'status' => 'sometimes|in:assigned,in_progress,completed',
            'assigned_at' => 'sometimes|date',
            'completed_at' => 'nullable|date',
        ]);

        $assignment->update($validated);

        return response()->json($assignment);
    }

    // Delete course assignment
    public function destroy($id)
    {
        $assignment = CourseAssignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'Course assignment not found'], 404);
        }

        $assignment->delete();
        return response()->json(['message' => 'Course assignment deleted successfully']);
    }
}