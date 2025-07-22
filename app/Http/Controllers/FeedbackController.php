<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Display all feedback
    public function index()
    {
        return response()->json(Feedback::all(), 200);
    }

    // Store new feedback
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'reviewer_id' => 'required|exists:employees,id',
            'feedback_text' => 'required|string',
            'type' => 'required|in:peer,manager',
        ]);

        $feedback = Feedback::create($validated);

        return response()->json($feedback, 201);
    }

    // Show specific feedback
    public function show($id)
    {
        $feedback = Feedback::find($id);
        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }
        return response()->json($feedback);
    }

    // Update feedback
    public function update(Request $request, $id)
    {
        $feedback = Feedback::find($id);
        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'reviewer_id' => 'sometimes|required|exists:employees,id',
            'feedback_text' => 'sometimes|required|string',
            'type' => 'sometimes|required|in:peer,manager',
        ]);

        $feedback->update($validated);

        return response()->json($feedback);
    }

    // Delete feedback
    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedback->delete();
        return response()->json(['message' => 'Feedback deleted successfully']);
    }
}
