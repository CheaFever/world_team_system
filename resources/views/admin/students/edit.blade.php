<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
<div class="max-w-4xl mx-auto px-4 py-10">
  <h1 class="text-2xl font-bold mb-6">Edit Student</h1>
  <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')
    @if($student->profile_image)
      <div class="mb-4">
        <img src="{{ asset('storage/' . $student->profile_image) }}" class="w-24 h-24 rounded-xl object-cover" alt="Current photo">
        <p class="text-xs text-slate-500 mt-1">Current profile image</p>
      </div>
    @endif
    @include('admin.students._form')
    <div class="flex gap-2">
      <button class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">Update</button>
      <a href="{{ route('admin.students.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm">Cancel</a>
    </div>
  </form>
</div>
</body>
</html>
