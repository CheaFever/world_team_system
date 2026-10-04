<?php
namespace App\Http\Controllers;

use App\Models\MeetingSunday;
use Illuminate\Http\Request;

class MeetingSundayController extends Controller
{
    // Display a listing of the records
    public function index()
    {
        $meetings = MeetingSunday::all();
        return view('meeting_sunday.index', compact('meetings'));
    }

    // Store a newly created record in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meetting_name' => 'required|string|max:255',
            'start' => 'required|date',
            'stop' => 'required|date|after:start',
        ]);

        MeetingSunday::create($validated);

        return redirect()->route('meeting-sunday.index')
            ->with('success', 'Meeting created successfully.');
    }

    // Update the specified record in storage
    public function update(Request $request, $id)
    {
        $meeting = MeetingSunday::findOrFail($id);

        $validated = $request->validate([
            'meetting_name' => 'required|string|max:255',
            'start' => 'required|date',
            'stop' => 'required|date|after:start',
        ]);

        $meeting->update($validated);

        return redirect()->route('meeting-sunday.index')
            ->with('success', 'Meeting updated successfully.');
    }

    // Remove the specified record from storage
    public function destroy($id)
    {
        $meeting = MeetingSunday::findOrFail($id);
        $meeting->delete();

        return redirect()->route('meeting-sunday.index')
            ->with('success', 'Meeting deleted successfully.');
    }
}