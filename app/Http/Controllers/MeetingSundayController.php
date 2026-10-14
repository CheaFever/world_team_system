<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\DormGroup;        // <-- កុំភ្លេច Import មួយនេះ
use App\Models\MeetingSunday;
use App\Models\Student;          // <-- កុំភ្លេច Import មួយនេះ
use Illuminate\Http\Request;

class MeetingSundayController extends Controller
{
    public function index(Request $request)
    {
        $meetings = MeetingSunday::all();
        $groups = DormGroup::all(); // <-- បន្ថែមត្រង់នេះដើម្បីកុំឱ្យបាត់ variable $groups

        // ទាញទិន្នន័យសិស្ស
        $studentQuery = Student::with('dormGroup')->latest();

        if ($search = $request->input('search')) {
            $studentQuery->where(function ($q) use ($search) {
                $q->where('student_ID', 'like', "%{$search}%")
                    ->orWhere('name_khmer', 'like', "%{$search}%")
                    ->orWhere('name_english', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        if ($groupId = $request->input('dorm_group_id')) {
            $studentQuery->where('dorm_group_id', $groupId);
        }

        $students = $studentQuery->get();

        // បញ្ជូន $meetings, $students, និង $groups ទៅកាន់ View
        return view('meeting_sunday.index', compact('meetings', 'students', 'groups'));
    }

    // មុខងារកត់វត្តមានសិស្ស
    public function updateStudentAttendance(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_time'  => 'required|integer|min:0',
            'absent'     => 'required|integer|min:0',
            'permission' => 'required|integer|min:0',
        ]);

        $student->update($validated);

        if ($student->absent >= 2 || $student->permission >= 4) {
            AdminNotification::create([
                'title'   => 'ការព្រមានអវត្តមានសិស្ស (Sunday Meeting)',
                'message' => "សិស្សឈ្មោះ {$student->name_khmer} (ID: {$student->student_ID}) មាន Absent: {$student->absent} ដង ឬ Permission: {$student->permission} ដង",
                'type'    => 'updated',
                'is_read' => false,
            ]);
        }

        return redirect()->route('meeting-sunday.index')
            ->with('success', "បានកត់ត្រាវត្តមានសម្រាប់សិស្ស {$student->name_khmer} ដោយជោគជ័យ។");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meetting_name' => 'required|string|max:255',
            'start'         => 'required|date',
            'stop'          => 'required|date|after:start',
        ]);

        MeetingSunday::create($validated);

        return redirect()->route('meeting-sunday.index')
            ->with('success', 'Meeting created successfully.');
    }

    public function update(Request $request, $id)
    {
        $meeting = MeetingSunday::findOrFail($id);

        $validated = $request->validate([
            'meetting_name' => 'required|string|max:255',
            'start'         => 'required|date',
            'stop'          => 'required|date|after:start',
        ]);

        $meeting->update($validated);

        return redirect()->route('meeting-sunday.index')
            ->with('success', 'Meeting updated successfully.');
    }

    public function destroy($id)
    {
        $meeting = MeetingSunday::findOrFail($id);
        $meeting->delete();

        return redirect()->route('meeting-sunday.index')
            ->with('success', 'Meeting deleted successfully.');
    }
}