<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    // Display a listing of documents
    public function index()
    {
        return response()->json(Document::all(), 200);
    }

    // Store a newly created document
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|string|max:255',
            'file_path' => 'required|string|max:255'
        ]);

        $document = Document::create($validated);

        return response()->json($document, 201);
    }

    // Display the specified document
    public function show($id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        return response()->json($document);
    }

    // Update the specified document
    public function update(Request $request, $id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:employees,id',
            'type' => 'sometimes|required|string|max:255',
            'file_path' => 'sometimes|required|string|max:255'
        ]);

        $document->update($validated);

        return response()->json($document);
    }

    // Remove the specified document
    public function destroy($id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
