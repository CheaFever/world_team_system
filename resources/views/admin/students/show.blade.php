<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
<div class="max-w-3xl mx-auto px-4 py-10">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Student Details</h1>
    <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 text-sm">← Back</a>
  </div>

  <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6 flex items-center gap-6">
    @if($student->profile_image)
      <img src="{{ asset('storage/' . $student->profile_image) }}" class="w-28 h-28 rounded-2xl object-cover" alt="Profile">
    @else
      <div class="w-28 h-28 rounded-2xl bg-slate-200 flex items-center justify-center text-slate-400">No photo</div>
    @endif
    <div>
      <h2 class="text-xl font-semibold">{{ $student->name_english }}</h2>
      <p class="text-slate-500">{{ $student->name_khmer }}</p>
      <p class="text-sm text-slate-500 mt-1">ID: {{ $student->student_ID }} · {{ $student->dormGroup?->group_name ?? 'No group' }}</p>
    </div>
  </div>

  <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
    <p><span class="font-medium">Gender:</span> {{ $student->gender }}</p>
    <p><span class="font-medium">Date of Birth:</span> {{ $student->date_of_birth?->format('Y-m-d') }}</p>
    <p><span class="font-medium">Place of Birth:</span> {{ $student->place_of_birth }}</p>
    <p><span class="font-medium">Phone:</span> {{ $student->phone_number }}</p>
    <p><span class="font-medium">Email:</span> {{ $student->email }}</p>
    <p><span class="font-medium">Family:</span> {{ $student->family }}</p>
    <p><span class="font-medium">Have Sibling:</span> {{ $student->have_sibling ? 'Yes' : 'No' }}</p>
    <p><span class="font-medium">Full Time:</span> {{ $student->full_time }}</p>
    <p><span class="font-medium">Absent:</span> {{ $student->absent }}</p>
    <p><span class="font-medium">Permission:</span> {{ $student->permission }}</p>
    <p><span class="font-medium">Dorm Group:</span> {{ $student->dormGroup?->group_name ?? '—' }}</p>
    <p><span class="font-medium">Mother:</span> {{ $student->mother_name }} · {{ $student->mother_phone }} · {{ $student->mother_job }}</p>
    <p><span class="font-medium">Father:</span> {{ $student->father_name }} · {{ $student->father_phone }} · {{ $student->father_job }}</p>
  </div>
</div>
</body>
</html>
