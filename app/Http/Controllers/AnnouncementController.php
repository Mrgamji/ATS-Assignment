<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    // Display all announcements
    public function index()
    {
        return response()->json(Announcement::all(), 200);
    }

    // Store a new announcement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'published_at' => 'required|date',
            'priority' => 'required|in:low,normal,high',
            'announcer_id' => 'nullable|exists:employees,id',
            'is_active' => 'boolean',
        ]);

        $announcement = Announcement::create($validated);

        return response()->json($announcement, 201);
    }

    // Show specific announcement
    public function show($id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found'], 404);
        }
        return response()->json($announcement);
    }

    // Update announcement
    public function update(Request $request, $id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'published_at' => 'sometimes|date',
            'priority' => 'sometimes|in:low,normal,high',
            'announcer_id' => 'nullable|exists:employees,id',
            'is_active' => 'boolean',
        ]);

        $announcement->update($validated);

        return response()->json($announcement);
    }

    // Delete announcement
    public function destroy($id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found'], 404);
        }

        $announcement->delete();
        return response()->json(['message' => 'Announcement deleted successfully']);
    }
}