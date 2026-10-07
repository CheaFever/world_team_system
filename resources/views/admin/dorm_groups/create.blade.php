<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Dorm Group</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
<div class="max-w-2xl mx-auto px-4 py-10">
  <h1 class="text-2xl font-bold mb-6">Create Dorm Group</h1>

  @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 text-sm">
      <ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.dorm-groups.store') }}" method="POST" class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 shadow-sm">
    @csrf
    <div>
      <label class="block text-sm font-medium mb-1">Group Name *</label>
      <input type="text" name="group_name" value="{{ old('group_name') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Description</label>
      <textarea name="description" rows="3" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">{{ old('description') }}</textarea>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Room Number</label>
      <input type="text" name="room_number" value="{{ old('room_number') }}" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Maximum Capacity (max 35) *</label>
      <input type="number" name="maximum_capacity" value="{{ old('maximum_capacity', 35) }}" min="1" max="35" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Status *</label>
      <select name="status" class="w-full rounded-xl border-slate-300 border px-3 py-2 text-sm">
        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
      </select>
    </div>
    <div class="flex gap-2">
      <button class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">Save</button>
      <a href="{{ route('admin.dorm-groups.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm">Cancel</a>
    </div>
  </form>
</div>
</body>
</html>
