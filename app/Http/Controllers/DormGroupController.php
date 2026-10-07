<?php

namespace App\Http\Controllers;

use App\Models\DormGroup;
use Illuminate\Http\Request;

class DormGroupController extends Controller
{
    // List all dorm groups
    public function index()
    {
        $groups = DormGroup::latest()->get();

        return view('admin.dorm_groups.index', compact('groups'));
    }

    // Show the create form
    public function create()
    {
        return view('admin.dorm_groups.create');
    }

    // Store a new dorm group
    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'room_number' => 'nullable|string|max:50',
            // Capacity must be between 1 and 35 (maximum 35 students per group)
            'maximum_capacity' => 'required|integer|min:1|max:35',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['current_number_of_students'] = 0;

        DormGroup::create($validated);

        return redirect()->route('admin.dorm-groups.index')->with('success', 'Dorm group created successfully.');
    }

    // Show group details (including its students)
    public function show(DormGroup $dormGroup)
    {
        $dormGroup->load('students');

        return view('admin.dorm_groups.show', compact('dormGroup'));
    }

    // Show the edit form
    public function edit(DormGroup $dormGroup)
    {
        return view('admin.dorm_groups.edit', compact('dormGroup'));
    }

    // Update a dorm group
    public function update(Request $request, DormGroup $dormGroup)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'room_number' => 'nullable|string|max:50',
            // Capacity must still fit the students already in the group
            'maximum_capacity' => 'required|integer|min:1|max:35',
            'status' => 'required|in:active,inactive',
        ]);

        // Extra safety: maximum_capacity may not be lower than the real student count
        $currentCount = $dormGroup->students()->count();
        if ($validated['maximum_capacity'] < $currentCount) {
            return back()->withErrors(['maximum_capacity' => "Capacity cannot be lower than the current number of students ({$currentCount})."])->withInput();
        }

        $dormGroup->update($validated);
        $dormGroup->syncStudentCount();

        return redirect()->route('admin.dorm-groups.index')->with('success', 'Dorm group updated successfully.');
    }

    // Delete a dorm group
    public function destroy(DormGroup $dormGroup)
    {
        $dormGroup->delete();

        return redirect()->route('admin.dorm-groups.index')->with('success', 'Dorm group deleted successfully.');
    }
}
