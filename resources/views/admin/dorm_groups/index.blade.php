<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dorm Groups</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
<div class="max-w-6xl mx-auto px-4 py-10">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
    <div>
      <h1 class="text-2xl font-bold text-slate-900">Dormitory Groups</h1>
      <p class="text-sm text-slate-500 mt-1">Manage dorm groups, rooms and capacities.</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm hover:bg-slate-100">← Dashboard</a>
      <a href="{{ route('admin.dorm-groups.create') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">+ New Group</a>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 text-sm">
      <ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  {{-- Groups table --}}
  <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Group Name</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Room</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Capacity</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Current Students</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($groups as $group)
            <tr class="hover:bg-slate-50">
              <td class="px-6 py-4 text-sm">{{ $group->id }}</td>
              <td class="px-6 py-4 text-sm font-medium">{{ $group->group_name }}</td>
              <td class="px-6 py-4 text-sm">{{ $group->room_number }}</td>
              <td class="px-6 py-4 text-sm">{{ $group->maximum_capacity }}</td>
              <td class="px-6 py-4 text-sm">{{ $group->students()->count() }}</td>
              <td class="px-6 py-4 text-sm">
                <span class="px-2 py-1 rounded-full text-xs {{ $group->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">{{ $group->status }}</span>
              </td>
              <td class="px-6 py-4 text-sm flex gap-2">
                <a href="{{ route('admin.dorm-groups.show', $group) }}" class="text-blue-600 hover:underline">View</a>
                <a href="{{ route('admin.dorm-groups.edit', $group) }}" class="text-amber-600 hover:underline">Edit</a>
                <form action="{{ route('admin.dorm-groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                  @csrf @method('DELETE')
                  <button class="text-rose-600 hover:underline">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="px-6 py-8 text-center text-slate-400">No groups found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
