<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Top Header & Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">All Events</h1>
                <p class="text-slate-500 text-sm mt-0.5">Manage schedules, categories, and published events</p>
            </div>
            <a href="{{ route('events.create') }}" 
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-md shadow-indigo-200 transition">
                <i class="fa-solid fa-plus"></i>
                Create Event
            </a>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Events Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200/80 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                            <th class="py-4 px-6">ID</th>
                            <th class="py-4 px-6">Event</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6">Time Schedule</th>
                            <th class="py-4 px-6">Organizer</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($events as $event)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-4 px-6 font-semibold text-slate-400">#{{ $event->event_ID }}</td>
                                
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3.5">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Banner" 
                                                 class="h-12 w-14 object-cover rounded-lg border border-slate-200 flex-shrink-0">
                                        @else
                                            <div class="h-12 w-14 bg-slate-100 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 flex-shrink-0">
                                                <i class="fa-regular fa-image text-lg"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-slate-800 line-clamp-1">{{ $event->type_of_event }}</p>
                                            <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $event->description ?? 'No description provided' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-slate-600 font-medium whitespace-nowrap">
                                    <i class="fa-regular fa-calendar text-slate-400 mr-1.5"></i>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                </td>

                                <td class="py-4 px-6 text-slate-600 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-semibold">
                                        <i class="fa-regular fa-clock text-slate-400"></i>
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-2 text-slate-700">
                                        <div class="h-7 w-7 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-600 font-semibold text-xs flex items-center justify-center">
                                            {{ strtoupper(substr($event->creator->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-xs">{{ $event->creator->name ?? 'Admin' }}</span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <form action="{{ route('events.destroy', $event->event_ID) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this event?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="h-8 w-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition inline-flex items-center justify-center"
                                                title="Delete Event">
                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <i class="fa-regular fa-folder-open text-4xl mb-3"></i>
                                        <p class="font-medium text-slate-600">No events found</p>
                                        <p class="text-sm text-slate-400 mt-1">Get started by creating a new event above.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Container -->
            @if($events->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>