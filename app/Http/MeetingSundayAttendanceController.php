<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\DormGroup;
use App\Models\Student;
use Illuminate\Http\Request;

class MeetingSundayAttendanceController extends Controller
{
    // បង្ហាញបញ្ជីសិស្សសម្រាប់កត់វត្តមាន Sunday Meeting
    public function index(Request $request)
    {
        $query = Student::with('dormGroup')->latest();

        // ស្វែងរកតាម Student ID, ឈ្មោះ, ឬលេខទូរស័ព្ទ
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('student_ID', 'like', "%{$search}%")
                    ->orWhere('name_khmer', 'like', "%{$search}%")
                    ->orWhere('name_english', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // ច្រោះតាម Dorm Group
        if ($groupId = $request->input('dorm_group_id')) {
            $query->where('dorm_group_id', $groupId);
        }

        $students = $query->get();
        $groups = DormGroup::all();

        return view('admin.meeting_sunday.index', compact('students', 'groups'));
    }

    // មុខងារសម្រាប់ Update តែវត្តមានសិស្ស (Full Time, Absent, Permission)
    public function updateAttendance(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_time'  => 'required|integer|min:0',
            'absent'     => 'required|integer|min:0',
            'permission' => 'required|integer|min:0',
        ]);

        $student->update([
            'full_time'  => $validated['full_time'],
            'absent'     => $validated['absent'],
            'permission' => $validated['permission'],
        ]);

        // បង្កើត Notification បើ Absent >= 2 ឬ Permission >= 4
        if ($student->absent >= 2 || $student->permission >= 4) {
            AdminNotification::create([
                'title'   => 'ការព្រមានអវត្តមានសិស្ស (Sunday Meeting)',
                'message' => "សិស្សឈ្មោះ {$student->name_khmer} (ID: {$student->student_ID}) មាន Absent: {$student->absent} ដង ឬ Permission: {$student->permission} ដង",
                'type'    => 'updated',
                'is_read' => false,
            ]);
        }

        return redirect()->back()->with('success', "បានកត់ត្រាវត្តមានសម្រាប់សិស្ស {$student->name_khmer} ដោយជោគជ័យ។");
    }
}