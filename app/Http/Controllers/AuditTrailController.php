<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrail;

class AuditTrailController extends Controller
{
    // Display all audit trails
    public function index()
    {
        return response()->json(AuditTrail::all(), 200);
    }

    // Store a new audit trail
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'action' => 'required|string|max:255',
            'target_table' => 'nullable|string|max:255',
            'target_id' => 'nullable|string|max:255',
            'ip_address' => 'nullable|ip',
            'details' => 'nullable|string',
        ]);

        $auditTrail = AuditTrail::create($validated);

        return response()->json($auditTrail, 201);
    }

    // Show specific audit trail
    public function show($id)
    {
        $auditTrail = AuditTrail::find($id);
        if (!$auditTrail) {
            return response()->json(['message' => 'Audit trail not found'], 404);
        }
        return response()->json($auditTrail);
    }

    // Update audit trail
    public function update(Request $request, $id)
    {
        $auditTrail = AuditTrail::find($id);
        if (!$auditTrail) {
            return response()->json(['message' => 'Audit trail not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'action' => 'sometimes|string|max:255',
            'target_table' => 'nullable|string|max:255',
            'target_id' => 'nullable|string|max:255',
            'ip_address' => 'nullable|ip',
            'details' => 'nullable|string',
        ]);

        $auditTrail->update($validated);

        return response()->json($auditTrail);
    }

    // Delete audit trail
    public function destroy($id)
    {
        $auditTrail = AuditTrail::find($id);
        if (!$auditTrail) {
            return response()->json(['message' => 'Audit trail not found'], 404);
        }

        $auditTrail->delete();
        return response()->json(['message' => 'Audit trail deleted successfully']);
    }
}
