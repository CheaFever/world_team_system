<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WT World Team Dom - Events Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- jsPDF and AutoTable for PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        sidebarBg: '#0f172a',
                        sidebarHover: '#1e293b',
                        sidebarActive: '#2563eb',
                        bodyBg: '#f8fafc'
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-bodyBg text-slate-800 antialiased min-h-screen flex overflow-x-hidden">
    @php
        $currentAdmin = Auth::guard('admin')->user();
        $unreadCount = \App\Models\AdminNotification::where('is_read', false)->count();
        $recentNotifications = \App\Models\AdminNotification::latest()->take(5)->get();
    @endphp

    <!-- Mobile Sidebar Backdrop -->
    <div
        id="sidebarBackdrop"
        class="fixed inset-0 bg-slate-900/60 z-30 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden backdrop-blur-sm"
    ></div>

    <!-- Sidebar -->
    <aside
        id="mainSidebar"
        class="fixed lg:sticky lg:top-0 top-0 bottom-0 left-0 w-64 h-screen bg-sidebarBg text-white flex flex-col justify-between z-40 -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none flex-shrink-0 border-r border-slate-800"
    >
        <div class="p-5 flex flex-col gap-6 overflow-y-auto">
            <!-- Branding -->
            <div class="flex items-center justify-between px-1 pt-1">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center p-0.5 shadow-lg shadow-blue-500/20 overflow-hidden border border-white/10">
                        <img
                            src="{{ asset('images/Logo WT.png') }}"
                            alt="WT Logo"
                            class="w-full h-full object-cover rounded-xl"
                            onerror="this.onerror=null; this.src='https://placehold.co/100x100/101c42/ffffff?text=WT';"
                        >
                    </div>

                    <div>
                        <h1 class="text-sm font-extrabold tracking-wide leading-tight text-white">WT</h1>
                        <p class="text-[12px] font-semibold text-slate-300 leading-tight">World Team Dom</p>
                        <p class="text-[10px] text-blue-400 font-medium">Build Your Future</p>
                    </div>
                </div>

                <button
                    id="closeSidebarBtn"
                    type="button"
                    class="lg:hidden text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-slate-800 transition"
                    aria-label="Close Sidebar"
                >
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-col gap-1.5">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-sidebarHover text-sm font-medium transition group">
                    <i class="fa-solid fa-house w-4 text-center group-hover:scale-110 transition"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.profile') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-sidebarHover text-sm font-medium transition group">
                    <i class="fa-regular fa-user w-4 text-center group-hover:scale-110 transition"></i>
                    <span>Profile</span>
                </a>

                <a href="{{ route('admin.dorm-groups.index') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-sidebarHover text-sm font-medium transition group">
                    <i class="fa-solid fa-bed w-4 text-center group-hover:scale-110 transition"></i>
                    <span>Dorm Groups</span>
                </a>

                <a href="{{ route('admin.students.index') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-sidebarHover text-sm font-medium transition group">
                    <i class="fa-solid fa-users w-4 text-center group-hover:scale-110 transition"></i>
                    <span>Student Information</span>
                </a>

                <a href="{{ route('meeting-sunday.index') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-sidebarHover text-sm font-medium transition group">
                    <i class="fa-regular fa-calendar w-4 text-center group-hover:scale-110 transition"></i>
                    <span>Meeting of Sunday</span>
                </a>

                <a href="{{ route('meeting-sunday.index') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-sidebarHover text-sm font-medium transition group">
                    <i class="fa-regular fa-calendar-days w-4 text-center group-hover:scale-110 transition"></i>
                    <span>Meeting Mon - Wed</span>
                </a>

                <a href="{{ route('meeting-sunday.index') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-sidebarHover text-sm font-medium transition group">
                    <i class="fa-regular fa-calendar-check w-4 text-center group-hover:scale-110 transition"></i>
                    <span>Meeting Sat &amp; Sun</span>
                </a>

                <!-- Events Active -->
                <a href="{{ route('events.index') }}"
                   aria-current="page"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition">
                    <i class="fa-regular fa-calendar-plus w-4 text-center"></i>
                    <span>Events</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer Banner -->
        <div class="relative overflow-hidden w-full p-4 border-t border-slate-800 bg-slate-900/50 flex-shrink-0">
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 font-bold text-xs">
                    WT
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-200">Admin Portal v2.5</p>
                    <p class="text-[10px] text-slate-400">Secure Management System</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 min-h-screen w-full">
        <!-- Top Navigation -->
        <header class="w-full bg-white/80 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between gap-3 px-4 sm:px-6 lg:px-8 sticky top-0 z-20 shadow-xs">
            <div class="flex items-center gap-3 flex-1 max-w-md min-w-0">
                <button
                    id="mobileMenuBtn"
                    type="button"
                    class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition"
                    aria-label="Open Navigation Menu"
                    aria-controls="mainSidebar"
                    aria-expanded="false"
                >
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <div class="relative w-full max-w-xs sm:max-w-sm">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input
                        id="eventSearchInput"
                        type="text"
                        placeholder="Search events..."
                        aria-label="Search Events"
                        class="w-full pl-9 pr-4 py-2 bg-slate-100/80 hover:bg-slate-100 focus:bg-white text-xs sm:text-sm rounded-xl border border-transparent focus:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition placeholder:text-slate-400 font-medium"
                    >
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 flex-shrink-0">
                <!-- Notifications -->
                <div class="relative">
                    <button
                        id="notifBtn"
                        type="button"
                        class="relative text-slate-600 hover:text-slate-900 transition p-2.5 rounded-xl hover:bg-slate-100 border border-slate-200/60"
                        aria-label="Notifications"
                        aria-expanded="false"
                    >
                        <i class="fa-regular fa-bell text-base"></i>
                        <span
                            id="notifBadge"
                            class="{{ $unreadCount > 0 ? '' : 'hidden' }} absolute -top-1 -right-1 bg-rose-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-white shadow-sm"
                        >{{ $unreadCount }}</span>
                    </button>

                    <div
                        id="notifDropdown"
                        class="hidden absolute right-0 mt-3 w-80 max-w-[calc(100vw-2rem)] bg-white border border-slate-200/80 rounded-2xl shadow-2xl py-2 z-50 overflow-hidden"
                    >
                        <div class="px-4 py-2.5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <span class="text-xs font-bold text-slate-800">Notifications</span>
                            <span class="text-[10px] bg-blue-100 text-blue-700 font-bold px-2 py-0.5 rounded-full">New</span>
                        </div>

                        <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
                            @php
                                $hasNotifs = isset($recentNotifications) && count($recentNotifications) > 0;
                            @endphp
                            @if ($hasNotifs)
                                @php
                                    foreach ($recentNotifications as $notif) {
                                        echo '<div class="p-3 hover:bg-slate-50 transition text-left">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 flex-shrink-0 rounded-full ' . ($notif->type === 'created' ? 'bg-emerald-500' : ($notif->type === 'updated' ? 'bg-amber-500' : 'bg-rose-500')) . '"></span>
                                                <p class="text-xs font-semibold text-slate-800">' . htmlspecialchars($notif->title) . '</p>
                                            </div>
                                            <p class="text-[11px] text-slate-600 mt-1 pl-4">' . htmlspecialchars($notif->message) . '</p>
                                            <span class="text-[9px] text-slate-400 mt-1 pl-4 block">' . $notif->created_at->diffForHumans() . '</span>
                                        </div>';
                                    }
                                @endphp
                            @else
                                <div class="p-6 text-center text-xs text-slate-400 font-medium">No new notifications</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Admin Profile Dropdown -->
                <div class="relative">
                    <button
                        id="adminDropdownTrigger"
                        type="button"
                        aria-expanded="false"
                        class="flex items-center gap-2.5 group p-1.5 rounded-2xl hover:bg-slate-100 border border-slate-200/60 transition"
                    >
                        <div class="w-9 h-9 rounded-xl ring-2 ring-blue-500/20 overflow-hidden bg-slate-200 flex items-center justify-center group-hover:ring-blue-500 transition">
                            @if ($currentAdmin && $currentAdmin->image && file_exists(public_path('uploads/admins/' . $currentAdmin->image)))
                                <img
                                    src="{{ asset('uploads/admins/' . $currentAdmin->image) }}"
                                    alt="Admin Photo"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($currentAdmin->username ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="hidden sm:flex flex-col text-left pr-1">
                            <span class="text-xs font-bold text-slate-800 leading-tight">
                                {{ $currentAdmin->full_name ?? $currentAdmin->username ?? 'Administrator' }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-semibold">Administrator</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 pr-1"></i>
                    </button>

                    <div
                        id="adminDropdownMenu"
                        class="hidden absolute right-0 mt-3 w-52 bg-white border border-slate-200/80 rounded-2xl shadow-2xl py-2 z-50 overflow-hidden"
                    >
                        <div class="px-4 py-2.5 border-b border-slate-100 bg-slate-50/50">
                            <p class="text-xs font-bold text-slate-800 truncate">
                                {{ $currentAdmin->full_name ?? $currentAdmin->username ?? 'Administrator' }}
                            </p>
                            <p class="text-[11px] text-slate-400 font-medium truncate">
                                #ADM-{{ str_pad($currentAdmin->id ?? 1, 4, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>

                        <a href="{{ route('admin.profile') }}"
                           class="px-4 py-2.5 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2.5 font-medium transition">
                            <i class="fa-regular fa-user text-slate-400"></i>
                            <span>My Profile</span>
                        </a>

                        <div class="border-t border-slate-100 my-1"></div>

                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 flex items-center gap-2.5 font-semibold transition">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Events Main Container -->
        <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full space-y-6">
            
            <!-- Header Banner with Export & Create Action Buttons -->
            <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-950 p-6 sm:p-8 rounded-3xl text-white shadow-xl flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 border border-slate-800">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-blue-300 text-xs font-semibold mb-3 border border-white/10">
                        <i class="fa-regular fa-calendar-days"></i>
                        <span>Events Overview</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Events Management</h1>
                    <p class="text-slate-300 text-sm mt-1 max-w-xl">
                        Manage your schedules, time slots, and easily export individual poster or all events into PDF reports.
                    </p>
                </div>

                <div class="relative z-10 flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <!-- Export All PDF Button -->
                    <button
                        type="button"
                        onclick="exportAllEventsPDF()"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs sm:text-sm px-4 py-3 rounded-2xl backdrop-blur-md border border-white/20 transition shadow-lg shadow-black/10 active:scale-95"
                    >
                        <i class="fa-solid fa-file-arrow-down text-blue-400"></i>
                        <span>Export All Events (PDF)</span>
                    </button>

                    <!-- Create Event Button -->
                    <a href="{{ route('events.create') }}"
                       class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-lg shadow-blue-600/30 transition active:scale-95 border border-blue-400/30">
                        <i class="fa-solid fa-plus-circle text-base"></i>
                        <span>Create Event</span>
                    </a>
                </div>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div role="status" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-sm animate-fade-in">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-500/20">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table Card Container -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></div>
                        <h2 class="text-sm font-bold text-slate-800">Active Events List</h2>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 bg-slate-200/60 px-3 py-1 rounded-full">
                        Total: {{ isset($events) ? count($events) : 0 }} Events
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table id="eventsTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-200/80 text-[11px] uppercase tracking-wider text-slate-500 font-extrabold">
                                <th scope="col" class="py-4 px-6">ID</th>
                                <th scope="col" class="py-4 px-6">Event</th>
                                <th scope="col" class="py-4 px-6">Date</th>
                                <th scope="col" class="py-4 px-6">Time Schedule</th>
                                <th scope="col" class="py-4 px-6">Organizer</th>
                                <th scope="col" class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 text-sm">
                            @php
                                $hasEvents = isset($events) && count($events) > 0;
                            @endphp

                            @if ($hasEvents)
                                @php
                                    foreach ($events as $event) {$imgUrl = $event->image ? asset('storage/' . $event->image) : '';
                                        $imgTag =$event->image 
                                            ? '<img src="' . $imgUrl . '" alt="' . htmlspecialchars($event->type_of_event) . '" class="h-12 w-14 object-cover rounded-xl border border-slate-200 shadow-sm flex-shrink-0 group-hover:scale-105 transition">'
                                            : '<div class="h-12 w-14 bg-gradient-to-tr from-slate-100 to-slate-200 border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 flex-shrink-0 shadow-sm"><i class="fa-regular fa-image text-lg"></i></div>';

                                        $formattedDate = \Carbon\Carbon::parse($event->event_date)->format('M d, Y');
                                        $formattedStartTime = \Carbon\Carbon::parse($event->start_time)->format('h:i A');
                                        $formattedEndTime = \Carbon\Carbon::parse($event->end_time)->format('h:i A');
                                        $creatorName =$event->creator->name ?? 'Admin';
                                        $creatorInitial = strtoupper(substr($creatorName, 0, 1));
                                        $descText =$event->description ?? 'No description provided';

                                        echo '<tr class="hover:bg-blue-50/30 transition group">
                                            <td class="py-4 px-6 font-bold text-slate-400 text-xs">#' . $event->event_ID . '</td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-4">
                                                    ' . $imgTag . '
                                                    <div class="min-w-0">
                                                        <p class="font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-1 text-sm">' . htmlspecialchars($event->type_of_event) . '</p>
                                                        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5 font-medium">' . htmlspecialchars($descText) . '</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-slate-700 font-semibold whitespace-nowrap text-xs">
                                                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">
                                                    <i class="fa-regular fa-calendar text-blue-500"></i> ' . $formattedDate . '
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-slate-700 whitespace-nowrap text-xs">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50/80 text-indigo-700 font-bold border border-indigo-100">
                                                    <i class="fa-regular fa-clock text-indigo-500"></i> ' . $formattedStartTime . ' - ' .$formattedEndTime . '
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                <div class="flex items-center gap-2.5 text-slate-700">
                                                    <div class="h-7 w-7 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">' . $creatorInitial . '</div>
                                                    <span class="font-bold text-xs text-slate-700">' . htmlspecialchars($creatorName) . '</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                                <div class="inline-flex items-center gap-2">
                                                    <button
                                                        type="button"
                                                        onclick="exportSingleEventPDF(\'' . $event->event_ID . '\', \'' . addslashes($event->type_of_event) . '\', \'' . addslashes($descText) . '\', \'' .$formattedDate . '\', \'' . $formattedStartTime . '\', \'' .$formattedEndTime . '\', \'' . addslashes($creatorName) . '\', \'' .$imgUrl . '\')"
                                                        class="h-9 px-3 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition inline-flex items-center gap-1.5 font-semibold text-xs shadow-sm"
                                                        title="Export Poster PDF for this event"
                                                    >
                                                        <i class="fa-solid fa-file-pdf text-sm"></i>
                                                        <span>Poster PDF</span>
                                                    </button>
                                                    <form
                                                        action="' . route('events.destroy', $event->event_ID) . '"
                                                        method="POST"
                                                        onsubmit="return confirm(\'Are you sure you want to delete this event?\');"
                                                        class="inline"
                                                    >
                                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button
                                                            type="submit"
                                                            class="h-9 w-9 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition inline-flex items-center justify-center shadow-sm"
                                                            title="Delete Event"
                                                            aria-label="Delete Event"
                                                        >
                                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>';
                                    }
                                @endphp
                            @else
                                <tr>
                                    <td colspan="6" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <div class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center text-slate-400 mb-3 shadow-inner">
                                                <i class="fa-regular fa-folder-open text-2xl"></i>
                                            </div>
                                            <p class="font-bold text-slate-700 text-base">No events found</p>
                                            <p class="text-xs text-slate-400 mt-1 max-w-xs">
                                                Get started by creating a new event using the button above.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if (isset($events) && method_exists($events, 'hasPages') &&$events->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- JavaScript & PDF Export Functions -->
    <script>
        // Mobile Sidebar Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const mainSidebar = document.getElementById('mainSidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function openSidebar() {
            mainSidebar.classList.remove('-translate-x-full');
            sidebarBackdrop.classList.remove('opacity-0', 'pointer-events-none');
            sidebarBackdrop.classList.add('opacity-100');
            mobileMenuBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            mainSidebar.classList.add('-translate-x-full');
            sidebarBackdrop.classList.remove('opacity-100');
            sidebarBackdrop.classList.add('opacity-0', 'pointer-events-none');
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        mobileMenuBtn.addEventListener('click', openSidebar);
        closeSidebarBtn.addEventListener('click', closeSidebar);
        sidebarBackdrop.addEventListener('click', closeSidebar);

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) closeSidebar();
        });

        // Admin Profile & Notification Dropdown Handlers
        const adminDropdownTrigger = document.getElementById('adminDropdownTrigger');
        const adminDropdownMenu = document.getElementById('adminDropdownMenu');
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');
        const notifBadge = document.getElementById('notifBadge');

        function hideDropdown(button, dropdown) {
            dropdown.classList.add('hidden');
            button.setAttribute('aria-expanded', 'false');
        }

        adminDropdownTrigger.addEventListener('click', () => {
            const opening = adminDropdownMenu.classList.contains('hidden');
            adminDropdownMenu.classList.toggle('hidden');
            adminDropdownTrigger.setAttribute('aria-expanded', String(opening));
            hideDropdown(notifBtn, notifDropdown);
        });

        notifBtn.addEventListener('click', () => {
            const opening = notifDropdown.classList.contains('hidden');
            notifDropdown.classList.toggle('hidden');
            notifBtn.setAttribute('aria-expanded', String(opening));
            hideDropdown(adminDropdownTrigger, adminDropdownMenu);

            if (opening && notifBadge && !notifBadge.classList.contains('hidden')) {
                notifBadge.classList.add('hidden');
                notifBadge.textContent = '0';
            }
        });

        document.addEventListener('click', (event) => {
            if (!adminDropdownMenu.contains(event.target) && !adminDropdownTrigger.contains(event.target)) {
                hideDropdown(adminDropdownTrigger, adminDropdownMenu);
            }
            if (!notifDropdown.contains(event.target) && !notifBtn.contains(event.target)) {
                hideDropdown(notifBtn, notifDropdown);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSidebar();
                hideDropdown(adminDropdownTrigger, adminDropdownMenu);
                hideDropdown(notifBtn, notifDropdown);
            }
        });

        // Search Filter Feature
        const eventSearchInput = document.getElementById('eventSearchInput');
        if (eventSearchInput) {
            eventSearchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#eventsTable tbody tr');
                rows.forEach(row => {
                    if(row.cells.length < 5) return;
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            });
        }

        // ==========================================
        // PDF EXPORT FUNCTIONS (POSTER STYLE WITH IMAGE)
        // ==========================================

        // 1. Export Single Event as a Poster PDF with Image
        function exportSingleEventPDF(id, type, desc, date, startTime, endTime, organizer, imageUrl) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const generatePDF = (imgData) => {
                // Header Background Banner
                doc.setFillColor(15, 23, 42); // slate-900
                doc.rect(0, 0, 210, 45, 'F');

                // Header Title
                doc.setTextColor(255, 255, 255);
                doc.setFont("helvetica", "bold");
                doc.setFontSize(20);
                doc.text("WT WORLD TEAM DOM", 14, 20);

                doc.setFontSize(11);
                doc.setTextColor(148, 163, 184);
                doc.text("OFFICIAL EVENT POSTER", 14, 29);

                doc.setFontSize(10);
                doc.text("Event ID: #" + id, 196, 20, { align: 'right' });
                doc.text("Date: " + new Date().toLocaleDateString(), 196, 29, { align: 'right' });

                let startY = 55;

                // Render Event Image as Poster Hero if available
                if (imgData) {
                    try {
                        doc.addImage(imgData, 'JPEG', 35, startY, 140, 75);
                        doc.setDrawColor(203, 213, 225);
                        doc.setLineWidth(0.8);
                        doc.rect(35, startY, 140, 75);
                        startY += 85;
                    } catch (e) {
                        console.error("Error drawing image onto PDF poster", e);
                        startY += 10;
                    }
                } else {
                    doc.setFillColor(241, 245, 249);
                    doc.rect(35, startY, 140, 40, 'F');
                    doc.setTextColor(148, 163, 184);
                    doc.setFontSize(11);
                    doc.text("No Image Available for this Event", 105, startY + 23, { align: 'center' });
                    startY += 50;
                }

                // Event Title / Poster Header
                doc.setFont("helvetica", "bold");
                doc.setFontSize(22);
                doc.setTextColor(15, 23, 42);
                doc.text(type, 105, startY, { align: 'center' });
                startY += 8;

                // Accent Line
                doc.setDrawColor(37, 99, 235);
                doc.setLineWidth(1.5);
                doc.line(70, startY, 140, startY);
                startY += 12;

                // Event Poster Details Card
                const details = [
                    ["Event Date:", date],
                    ["Time Schedule:", startTime + " - " + endTime],
                    ["Organizer:", organizer],
                    ["Description:", desc || "No description provided"]
                ];

                let currentY = startY;
                details.forEach(item => {
                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(11);
                    doc.setTextColor(30, 41, 59);
                    doc.text(item[0], 25, currentY);

                    doc.setFont("helvetica", "normal");
                    doc.setTextColor(71, 85, 105);
                    const splitText = doc.splitTextToSize(item[1], 120);
                    doc.text(splitText, 65, currentY);
                    currentY += (splitText.length * 7) + 4;
                });

                // Poster Footer
                doc.setFontSize(9);
                doc.setTextColor(148, 163, 184);
                doc.text("WT World Team Dom Administration System - Official Event Report", 105, 285, { align: 'center' });

                doc.save(`Event_Poster_${id}.pdf`);
            };

            // Load image via Canvas to convert into Base64 for jsPDF
            if (imageUrl) {
                const img = new Image();
                img.crossOrigin = 'Anonymous';
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.naturalWidth || img.width;
                    canvas.height = img.naturalHeight || img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    let dataURL = '';
                    try {
                        dataURL = canvas.toDataURL('image/jpeg', 0.9);
                    } catch (err) {
                        dataURL = null;
                    }
                    generatePDF(dataURL);
                };
                img.onerror = function() {
                    generatePDF(null);
                };
                img.src = imageUrl;
            } else {
                generatePDF(null);
            }
        }

        // 2. Export All Events PDF
        function exportAllEventsPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFillColor(15, 23, 42);
            doc.rect(0, 0, 210, 35, 'F');

            doc.setTextColor(255, 255, 255);
            doc.setFont("helvetica", "bold");
            doc.setFontSize(18);
            doc.text("WT WORLD TEAM DOM", 14, 20);

            doc.setFontSize(10);
            doc.setTextColor(148, 163, 184);
            doc.text("All Events Summary Report", 14, 27);

            doc.setTextColor(51, 65, 85);
            doc.setFontSize(11);
            doc.text("Generated Date: " + new Date().toLocaleDateString(), 14, 45);

            const rows = document.querySelectorAll('#eventsTable tbody tr');
            const tableData = [];

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 6) {
                    const eventId = cells[0].innerText.trim();
                    const eventTitle = cells[1].querySelector('p.font-bold') ? cells[1].querySelector('p.font-bold').innerText.trim() : '';
                    const eventDate = cells[2].innerText.trim();
                    const eventTime = cells[3].innerText.trim();
                    const organizer = cells[4].innerText.trim();

                    tableData.push([eventId, eventTitle, eventDate, eventTime, organizer]);
                }
            });

            if (tableData.length === 0) {
                alert("No event data available to export.");
                return;
            }

            doc.autoTable({
                startY: 55,
                head: [['ID', 'Event Title', 'Date', 'Time Schedule', 'Organizer']],
                body: tableData,
                theme: 'striped',
                headStyles: { fillColor: [37, 99, 235], textColor: [255, 255, 255], fontStyle: 'bold' },
                bodyStyles: { textColor: [51, 65, 85], fontSize: 10 },
            });

            doc.save(`All_Events_Report_${new Date().toISOString().slice(0,10)}.pdf`);
        }
    </script>
</body>
</html>