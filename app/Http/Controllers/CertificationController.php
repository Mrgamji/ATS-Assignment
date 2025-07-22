<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certification;

class CertificationController extends Controller
{
    // Display all certifications
    public function index()
    {
        return response()->json(Certification::all(), 200);
    }

    // Store new certification
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'certificate_name' => 'required|string|max:255',
            'file_path' => 'nullable|string',
            'issued_date' => 'required|date',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $certification = Certification::create($validated);

        return response()->json($certification, 201);
    }

    // Show specific certification
    public function show($id)
    {
        $certification = Certification::find($id);
        if (!$certification) {
            return response()->json(['message' => 'Certification not found'], 404);
        }
        return response()->json($certification);
    }

    // Update certification
    public function update(Request $request, $id)
    {
        $certification = Certification::find($id);
        if (!$certification) {
            return response()->json(['message' => 'Certification not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'certificate_name' => 'sometimes|string|max:255',
            'file_path' => 'nullable|string',
            'issued_date' => 'sometimes|date',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $certification->update($validated);

        return response()->json($certification);
    }

    // Delete certification
    public function destroy($id)
    {
        $certification = Certification::find($id);
        if (!$certification) {
            return response()->json(['message' => 'Certification not found'], 404);
        }

        $certification->delete();
        return response()->json(['message' => 'Certification deleted successfully']);
    }
}