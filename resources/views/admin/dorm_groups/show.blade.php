<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Group Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
<div class="max-w-4xl mx-auto px-4 py-10">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">{{ $dormGroup->group_name }}</h1>
    <a href="{{ route('admin.dorm-groups.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 text-sm">← Back</a>
  </div>

  <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6 space-y-2 text-sm">
    <p><span class="font-medium">Description:</span> {{ $dormGroup->description }}</p>
    <p><span class="font-medium">Room Number:</span> {{ $dormGroup->room_number }}</p>
    <p><span class="font-medium">Maximum Capacity:</span> {{ $dormGroup->maximum_capacity }}</p>
    <p><span class="font-medium">Current Students:</span> {{ $dormGroup->students->count() }}</p>
    <p><span class="font-medium">Status:</span> {{ $dormGroup->status }}</p>
  </div>

  <h2 class="text-lg font-semibold mb-3">Students in this group</h2>
  <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    <table class="min-w-full divide-y divide-slate-200">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Student ID</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Khmer Name</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">English Name</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Phone</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($dormGroup->students as $student)
          <tr>
            <td class="px-6 py-4 text-sm">{{ $student->student_ID }}</td>
            <td class="px-6 py-4 text-sm">{{ $student->name_khmer }}</td>
            <td class="px-6 py-4 text-sm">{{ $student->name_english }}</td>
            <td class="px-6 py-4 text-sm">{{ $student->phone_number }}</td>
          </tr>
        @empty
          <tr><td colspan="4" class="px-6 py-6 text-center text-slate-400">No students assigned.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
