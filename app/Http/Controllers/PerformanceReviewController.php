<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerformanceReview;

class PerformanceReviewController extends Controller
{
    // Display all performance reviews
    public function index()
    {
        return response()->json(PerformanceReview::all(), 200);
    }

    // Store a new performance review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period' => 'required|in:mid_year,annual',
            'review_year' => 'required|digits:4|integer|min:2000',
            'reviewer_id' => 'required|exists:employees,id',
            'comments' => 'nullable|string',
            'score' => 'nullable|numeric|min:0|max:100'
        ]);

        $review = PerformanceReview::create($validated);

        return response()->json($review, 201);
    }

    // Show a specific review
    public function show($id)
    {
        $review = PerformanceReview::find($id);
        if (!$review) {
            return response()->json(['message' => 'Performance review not found'], 404);
        }
        return response()->json($review);
    }

    // Update a performance review
    public function update(Request $request, $id)
    {
        $review = PerformanceReview::find($id);
        if (!$review) {
            return response()->json(['message' => 'Performance review not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'period' => 'sometimes|required|in:mid_year,annual',
            'review_year' => 'sometimes|required|digits:4|integer|min:2000',
            'reviewer_id' => 'sometimes|required|exists:employees,id',
            'comments' => 'nullable|string',
            'score' => 'nullable|numeric|min:0|max:100'
        ]);

        $review->update($validated);

        return response()->json($review);
    }

    // Delete a review
    public function destroy($id)
    {
        $review = PerformanceReview::find($id);
        if (!$review) {
            return response()->json(['message' => 'Performance review not found'], 404);
        }
        $review->delete();

        return response()->json(['message' => 'Performance review deleted successfully']);
    }
}
