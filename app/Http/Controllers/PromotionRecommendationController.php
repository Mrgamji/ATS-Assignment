<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromotionRecommendation;

class PromotionRecommendationController extends Controller
{
    // Display all promotion recommendations
    public function index()
    {
        return response()->json(PromotionRecommendation::all(), 200);
    }

    // Store new promotion recommendation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'recommended_by' => 'required|exists:employees,id',
            'recommended' => 'required|boolean',
            'justification' => 'nullable|string',
            'recommended_at' => 'nullable|date',
        ]);

        $recommendation = PromotionRecommendation::create($validated);

        return response()->json($recommendation, 201);
    }

    // Show specific promotion recommendation
    public function show($id)
    {
        $recommendation = PromotionRecommendation::find($id);
        if (!$recommendation) {
            return response()->json(['message' => 'Promotion recommendation not found'], 404);
        }
        return response()->json($recommendation);
    }

    // Update promotion recommendation
    public function update(Request $request, $id)
    {
        $recommendation = PromotionRecommendation::find($id);
        if (!$recommendation) {
            return response()->json(['message' => 'Promotion recommendation not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'recommended_by' => 'sometimes|required|exists:employees,id',
            'recommended' => 'sometimes|required|boolean',
            'justification' => 'nullable|string',
            'recommended_at' => 'nullable|date',
        ]);

        $recommendation->update($validated);

        return response()->json($recommendation);
    }

    // Delete promotion recommendation
    public function destroy($id)
    {
        $recommendation = PromotionRecommendation::find($id);
        if (!$recommendation) {
            return response()->json(['message' => 'Promotion recommendation not found'], 404);
        }

        $recommendation->delete();
        return response()->json(['message' => 'Promotion recommendation deleted successfully']);
    }
}