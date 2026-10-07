{{-- Shared student form fields (used by create + edit) --}}
@if($errors->any())
  <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 text-sm">
    <ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
  </div>
@endif

<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
  {{-- Personal Information --}}
  <h2 class="text-lg font-semibold text-slate-900 border-b pb-2">Personal Information</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Student ID *</label>
      <input type="text" name="student_ID" value="{{ old('student_ID', $student?->student_ID ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Dorm Group *</label>
      <select name="dorm_group_id" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
        <option value="">-- Select a group --</option>
        @foreach($groups as $group)
          <option value="{{ $group->id }}" {{ (string) old('dorm_group_id', $student?->dorm_group_id ?? '') === (string) $group->id ? 'selected' : '' }}>
            {{ $group->group_name }} ({{ $group->students()->count() }}/{{ $group->maximum_capacity }})
          </option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Name (Khmer) *</label>
      <input type="text" name="name_khmer" value="{{ old('name_khmer', $student?->name_khmer ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Name (English) *</label>
      <input type="text" name="name_english" value="{{ old('name_english', $student?->name_english ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Gender *</label>
      <select name="gender" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
        <option value="">-- Select --</option>
        <option value="male" {{ old('gender', $student?->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('gender', $student?->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
        <option value="other" {{ old('gender', $student?->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Date of Birth *</label>
      <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($student) ? $student?->date_of_birth?->format('Y-m-d') : '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Place of Birth</label>
      <input type="text" name="place_of_birth" value="{{ old('place_of_birth', $student?->place_of_birth ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Phone Number *</label>
      <input type="text" name="phone_number" value="{{ old('phone_number', $student?->phone_number ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Email *</label>
      <input type="email" name="email" value="{{ old('email', $student?->email ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Family</label>
      <input type="text" name="family" value="{{ old('family', $student?->family ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div class="flex items-center gap-2 mt-6">
      <input type="checkbox" id="have_sibling" name="have_sibling" value="1" {{ old('have_sibling', $student?->have_sibling ?? false) ? 'checked' : '' }}>
      <label for="have_sibling" class="text-sm font-medium">Have Sibling</label>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Profile Image (jpg, png, webp, gif, max 2MB)</label>
      <input type="file" name="profile_image" accept="image/*" class="w-full text-sm">
    </div>
  </div>

  {{-- Attendance --}}
  <h2 class="text-lg font-semibold text-slate-900 border-b pb-2">Attendance</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Full Time</label>
      <input type="number" min="0" name="full_time" value="{{ old('full_time', $student?->full_time ?? 0) }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Absent</label>
      <input type="number" min="0" name="absent" value="{{ old('absent', $student?->absent ?? 0) }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Permission</label>
      <input type="number" min="0" name="permission" value="{{ old('permission', $student?->permission ?? 0) }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
  </div>

  {{-- Mother --}}
  <h2 class="text-lg font-semibold text-slate-900 border-b pb-2">Mother Information</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Mother Name</label>
      <input type="text" name="mother_name" value="{{ old('mother_name', $student?->mother_name ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Mother Phone</label>
      <input type="text" name="mother_phone" value="{{ old('mother_phone', $student?->mother_phone ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Mother Job</label>
      <input type="text" name="mother_job" value="{{ old('mother_job', $student?->mother_job ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
  </div>

  {{-- Father --}}
  <h2 class="text-lg font-semibold text-slate-900 border-b pb-2">Father Information</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Father Name</label>
      <input type="text" name="father_name" value="{{ old('father_name', $student?->father_name ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Father Phone</label>
      <input type="text" name="father_phone" value="{{ old('father_phone', $student?->father_phone ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Father Job</label>
      <input type="text" name="father_job" value="{{ old('father_job', $student?->father_job ?? '') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
  </div>
</div>
