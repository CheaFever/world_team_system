<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
<div class="max-w-7xl mx-auto px-4 py-10">
  <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-900">Student Registrations</h1>
      <p class="text-sm text-slate-500 mt-1">Manage student records and dorm assignments.</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm hover:bg-slate-100">← Dashboard</a>
      <a href="{{ route('admin.students.create') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">+ New Student</a>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
  @endif

  {{-- Search & Filter --}}
  <form method="GET" action="{{ route('admin.students.index') }}" class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID, name, phone, email..." class="flex-1 rounded-xl border-slate-300 border px-3 py-2 text-sm">
    <select name="gender" class="rounded-xl border-slate-300 border px-3 py-2 text-sm">
      <option value="">All genders</option>
      <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
      <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
      <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }}>Other</option>
    </select>
    <select name="dorm_group_id" class="rounded-xl border-slate-300 border px-3 py-2 text-sm">
      <option value="">All groups</option>
      @foreach($groups as $group)
        <option value="{{ $group->id }}" {{ request('dorm_group_id') == $group->id ? 'selected' : '' }}>{{ $group->group_name }}</option>
      @endforeach
    </select>
    <button class="px-4 py-2 rounded-xl bg-slate-800 text-white text-sm">Filter</button>
    <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 text-sm text-center">Reset</a>
  </form>

  <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Photo</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Student ID</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Khmer Name</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">English Name</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Gender</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Phone</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Email</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Dorm Group</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($students as $student)
            <tr class="hover:bg-slate-50">
              <td class="px-4 py-3">
                @if($student->profile_image)
                  <img src="{{ asset('storage/' . $student->profile_image) }}" class="w-10 h-10 rounded-full object-cover" alt="">
                @else
                  <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 text-xs">N/A</div>
                @endif
              </td>
              <td class="px-4 py-3 text-sm">{{ $student->student_ID }}</td>
              <td class="px-4 py-3 text-sm">{{ $student->name_khmer }}</td>
              <td class="px-4 py-3 text-sm font-medium">{{ $student->name_english }}</td>
              <td class="px-4 py-3 text-sm">{{ $student->gender }}</td>
              <td class="px-4 py-3 text-sm">{{ $student->phone_number }}</td>
              <td class="px-4 py-3 text-sm">{{ $student->email }}</td>
              <td class="px-4 py-3 text-sm">{{ $student->dormGroup?->group_name ?? '—' }}</td>
              <td class="px-4 py-3 text-sm flex gap-3">
                <a href="{{ route('admin.students.show', $student) }}" class="text-blue-600 hover:underline">View</a>
                <a href="{{ route('admin.students.edit', $student) }}" class="text-amber-600 hover:underline">Edit</a>
                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                  @csrf @method('DELETE')
                  <button class="text-rose-600 hover:underline">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="px-6 py-8 text-center text-slate-400">No students found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
