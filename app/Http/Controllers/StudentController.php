<?php

namespace App\Http\Controllers;

use App\Models\DormGroup;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // List students (with dorm group)
    public function index(Request $request)
    {
        $query = Student::with('dormGroup')->latest();

        // --- Search by student ID, Khmer name, English name, phone, email ---
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('student_ID', 'like', "%{$search}%")
                    ->orWhere('name_khmer', 'like', "%{$search}%")
                    ->orWhere('name_english', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // --- Filter by gender / dorm group ---
        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }
        if ($groupId = $request->input('dorm_group_id')) {
            $query->where('dorm_group_id', $groupId);
        }

        $students = $query->get();
        $groups = DormGroup::all();

        return view('admin.students.index', compact('students', 'groups'));
    }

    public function create()
    {
        $groups = DormGroup::all();

        return view('admin.students.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        // Capacity check before assigning the group
        if ($error = $this->capacityError($validated['dorm_group_id'] ?? null, null)) {
            return back()->withErrors(['dorm_group_id' => $error])->withInput();
        }

        // Upload profile image (validated: jpg/png/jpeg/gif/webp, max 2MB)
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $student = Student::create($validated);

        // Keep the group's student counter in sync
        if ($student->dormGroup) {
            $student->dormGroup->syncStudentCount();
        }

        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully.');
    }

    public function show(Student $student)
    {
        $student->load('dormGroup');

        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $groups = DormGroup::all();

        return view('admin.students.edit', compact('student', 'groups'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate($this->rules($student->id));

        // Capacity check when changing (or keeping) a group
        if ($error = $this->capacityError($validated['dorm_group_id'] ?? null, $student)) {
            return back()->withErrors(['dorm_group_id' => $error])->withInput();
        }

        $oldGroupId = $student->dorm_group_id;

        if ($request->hasFile('profile_image')) {
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $student->update($validated);

        // Recalculate counters for the old and the new group
        if ($oldGroupId && $oldGroupId != $student->dorm_group_id) {
            DormGroup::find($oldGroupId)?->syncStudentCount();
        }
        if ($student->dormGroup) {
            $student->dormGroup->syncStudentCount();
        }

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $group = $student->dormGroup;

        if ($student->profile_image) {
            Storage::disk('public')->delete($student->profile_image);
        }

        $student->delete();

        // Keep the old group's counter in sync
        $group?->syncStudentCount();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    // Shared validation rules
    private function rules(?int $ignoreId = null): array
    {
        $uniqueStudentId = $ignoreId ? "unique:students,student_ID,{$ignoreId}" : 'unique:students,student_ID';
        $uniqueEmail = $ignoreId ? "required|email|unique:students,email,{$ignoreId}" : 'required|email|unique:students,email';

        return [
            'dorm_group_id' => 'required|exists:dorm_groups,id',
            'student_ID' => "required|string|max:50|{$uniqueStudentId}",
            'name_khmer' => 'required|string|max:255',
            'name_english' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'place_of_birth' => 'nullable|string|max:255',
            'phone_number' => 'required|string|regex:/^[0-9+\-\s]{8,20}$/',
            'full_time' => 'nullable|integer|min:0',
            'absent' => 'nullable|integer|min:0',
            'permission' => 'nullable|integer|min:0',
            'email' => $uniqueEmail,
            'family' => 'nullable|string|max:255',
            'have_sibling' => 'nullable|boolean',
            'mother_name' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|max:20',
            'mother_job' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:20',
            'father_job' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ];
    }

    // Capacity protection: block assignment when the group is full (e.g. 35/35)
    private function capacityError(?int $groupId, ?Student $currentStudent): ?string
    {
        if (! $groupId) {
            return null;
        }

        $group = DormGroup::find($groupId);
        if (! $group) {
            return 'Selected dorm group does not exist.';
        }

        $count = $group->students()->count();

        // If we are updating and the student is already in this group, don't count them twice
        if ($currentStudent && $currentStudent->dorm_group_id == $groupId) {
            $count--;
        }

        if ($count >= $group->maximum_capacity) {
            return 'Cannot assign this student to the selected group because the dormitory group is full.';
        }

        return null;
    }
}
