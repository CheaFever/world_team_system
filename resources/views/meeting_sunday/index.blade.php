<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WT World Team Dom - Meeting Sunday Management</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Inter Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            sidebarBg: '#101c42',
            sidebarHover: '#1a2c63',
            sidebarActive: '#3b82f6',
            bodyBg: '#f8fafc',
          }
        }
      }
    }
  </script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      -webkit-tap-highlight-color: transparent;
    }
    ::-webkit-scrollbar {
      width: 5px;
      height: 5px;
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
    [x-cloak] { display: none !important; }
  </style>
</head>
<body 
  class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex overflow-x-hidden"
  x-data="{ 
    openCreateModal: false, 
    openEditModal: false, 
    editData: {},
    openAttendanceModal: false,
    attendData: { id: '', name: '', student_ID: '', full_time: 0, absent: 0, permission: 0 }
  }"
>

  @php
    $currentAdmin = Auth::guard('admin')->user();
    $unreadCount = \App\Models\AdminNotification::where('is_read', false)->count();
    $recentNotifications = \App\Models\AdminNotification::latest()->take(5)->get();
  @endphp

  <!-- MOBILE SIDEBAR BACKDROP OVERLAY -->
  <div 
    id="sidebarBackdrop" 
    class="fixed inset-0 bg-slate-900/60 z-30 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden backdrop-blur-xs"
  ></div>

  <!-- SIDEBAR (ដូច Dashboard ទាំងស្រុង) -->
  <aside 
    id="mainSidebar" 
    class="fixed lg:static top-0 bottom-0 left-0 w-64 bg-[#101c42] text-white flex flex-col justify-between z-40 -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none flex-shrink-0 min-h-screen"
  >
    <!-- Top Branding & Navigation -->
    <div class="p-5 flex flex-col gap-5 overflow-y-auto">
      
      <!-- Brand Logo & Name -->
      <div class="flex items-center justify-between px-1 pt-1">
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center p-0.5 shadow-sm overflow-hidden border-2 border-white/80">
            <img 
              id="schoolLogoImg" 
              src="{{ asset('images/Logo WT.png') }}" 
              alt="WT Logo" 
              class="w-full h-full object-cover rounded-full"
              onerror="this.onerror=null; this.src='https://placehold.co/100x100/101c42/ffffff?text=WT';"
            />
          </div>

          <div>
            <div class="flex items-center gap-1.5">
              <h1 class="text-sm font-bold tracking-wide leading-tight text-white">WT</h1>
            </div>
            <p class="text-[13px] font-semibold text-slate-100 leading-tight">World Team Dom</p>
            <p class="text-[10px] text-slate-400 font-normal">Build Your Future</p>
          </div>
        </div>

        <button 
          id="closeSidebarBtn" 
          class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg focus:outline-none"
          aria-label="Close Sidebar"
        >
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <!-- Navigation Menu -->
      <nav class="flex flex-col gap-1.5 mt-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-solid fa-house w-4 text-center"></i>
          <span>Dashboard</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-regular fa-user w-4 text-center"></i>
          <span>Profile</span>
        </a>

        <!-- Dorm Groups -->
        <a href="{{ route('admin.dorm-groups.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-solid fa-bed w-4 text-center"></i>
          <span>Dorm Groups</span>
        </a>

        <!-- Student Information -->
        <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-solid fa-users w-4 text-center"></i>
          <span>Student Information</span>
        </a>

        <!-- Meeting of Sunday (ACTIVE) -->
        <a href="{{ route('meeting-sunday.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl bg-[#3b82f6] text-white text-sm font-semibold shadow-sm transition">
          <i class="fa-regular fa-calendar w-4 text-center"></i>
          <span>Meeting of Sunday</span>
        </a>

        <!-- Meeting of Monday to Wednesday -->
        <a href="#" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-regular fa-calendar-days w-4 text-center"></i>
          <span>Meeting of Monday to Wednesday</span>
        </a>

        <!-- Meeting of Saturday & Sunday -->
        <a href="#" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-regular fa-calendar-check w-4 text-center"></i>
          <span>Meeting of Saturday & Sunday</span>
        </a>

        <!-- Events -->
        <a href="#" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-regular fa-calendar-plus w-4 text-center"></i>
          <span>Events</span>
        </a>
      </nav>
    </div>

    <!-- Bottom Sidebar Quote Card -->
    <div class="relative overflow-hidden w-full h-40 flex flex-col justify-end p-4 border-t border-slate-700/50 flex-shrink-0">
      <img 
        src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=600&q=80" 
        alt="Campus Building" 
        class="absolute inset-0 w-full h-full object-cover opacity-30 filter brightness-75"
        onerror="this.onerror=null; this.src='https://placehold.co/600x300/101c42/ffffff?text=Western+Campus';"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-[#101c42] via-[#101c42]/80 to-transparent"></div>
      
      <div class="relative z-10 text-center">
        <p class="text-[12px] font-semibold text-slate-100 tracking-tight leading-snug">Education is the key</p>
        <p class="text-[12px] font-semibold text-slate-100 tracking-tight leading-snug">to a brighter future</p>
      </div>
    </div>
  </aside>

  <!-- MAIN CONTENT CONTAINER -->
  <main class="flex-1 flex flex-col min-w-0 min-h-screen overflow-y-auto w-full">
    
    <!-- TOP NAVIGATION BAR (Header ដូច Dashboard ទាំងស្រុង) -->
    <header class="w-full bg-white border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
      
      <!-- Left: Mobile Menu Toggle & Title -->
      <div class="flex items-center gap-3 flex-1 max-w-md">
        <button 
          id="mobileMenuBtn" 
          class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 focus:outline-none transition active:scale-95"
          aria-label="Open Navigation Menu"
        >
          <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <div class="flex items-center gap-2">
          <i class="fa-regular fa-calendar text-blue-600 text-lg"></i>
          <span class="text-sm font-bold text-slate-800">Sunday Meeting Management & Attendance</span>
        </div>
      </div>

      <!-- Right: Notifications & Admin Profile Section -->
      <div class="flex items-center gap-3 sm:gap-5">
        
        <!-- DYNAMIC NOTIFICATION SECTION -->
        <div class="relative">
          <button 
            id="notifBtn" 
            class="relative text-slate-600 hover:text-slate-900 transition p-2 rounded-full hover:bg-slate-50 focus:outline-none" 
            aria-label="Notifications"
          >
            <i class="fa-regular fa-bell text-base sm:text-lg"></i>
            
            <!-- បង្ហាញ Badge លេខក្រហមពេលមាន Notification ថ្មី -->
            <span 
              id="notifBadge" 
              class="{{ $unreadCount > 0 ? '' : 'hidden' }} absolute top-1 right-1 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border-2 border-white"
            >
              {{ $unreadCount }}
            </span>
          </button>

          <!-- Notification Dropdown Menu -->
          <div 
            id="notifDropdown" 
            class="hidden absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 transition-all"
          >
            <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
              <span class="text-xs font-bold text-slate-800">Notifications</span>
              <span class="text-[10px] bg-blue-50 text-blue-600 font-semibold px-2 py-0.5 rounded-full">
                ថ្មីៗ
              </span>
            </div>

            <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
              @forelse($recentNotifications as $notif)
                <div class="p-3 hover:bg-slate-50 transition text-left">
                  <div class="flex items-center gap-2">
                    @if($notif->type === 'created')
                      <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    @elseif($notif->type === 'updated')
                      <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    @else
                      <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    @endif
                    <p class="text-xs font-semibold text-slate-800">{{ $notif->title }}</p>
                  </div>
                  <p class="text-[11px] text-slate-600 mt-1 pl-4">{{ $notif->message }}</p>
                  <span class="text-[9px] text-slate-400 mt-1 pl-4 block">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
              @empty
                <div class="p-4 text-center text-xs text-slate-400">
                  មិនមានដំណឹងថ្មីទេ
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Admin Profile Dropdown Button -->
        <div class="relative">
          <div 
            id="adminDropdownTrigger" 
            class="flex items-center gap-2.5 cursor-pointer group p-1.5 rounded-full hover:bg-slate-100 transition select-none"
          >
            <!-- Avatar -->
            <div class="w-9 h-9 rounded-full ring-2 ring-blue-500/30 overflow-hidden bg-slate-200 flex items-center justify-center shadow-inner group-hover:ring-blue-500 transition">
              @if($currentAdmin && $currentAdmin->image && file_exists(public_path('uploads/admins/' . $currentAdmin->image)))
                <img 
                  src="{{ asset('uploads/admins/' . $currentAdmin->image) }}" 
                  alt="Admin Photo" 
                  class="w-full h-full object-cover"
                />
              @else
                <div class="w-full h-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                  {{ strtoupper(substr($currentAdmin->username ?? 'A', 0, 1)) }}
                </div>
              @endif
            </div>

            <!-- Admin Name -->
            <div class="hidden sm:flex flex-col text-left">
              <span class="text-xs sm:text-sm font-bold text-slate-800 leading-tight">
                {{ $currentAdmin->full_name ?? $currentAdmin->username ?? 'Administrator' }}
              </span>
              <span class="text-[10px] text-slate-400 font-medium">Administrator</span>
            </div>

            <i class="fa-solid fa-chevron-down text-[10px] text-slate-500 ml-0.5"></i>
          </div>

          <!-- Dropdown Menu -->
          <div 
            id="adminDropdownMenu" 
            class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 transition-all duration-200"
          >
            <div class="px-4 py-2 border-b border-slate-100">
              <p class="text-xs font-semibold text-slate-800 truncate">
                {{ $currentAdmin->full_name ?? $currentAdmin->username ?? 'Administrator' }}
              </p>
              <p class="text-[11px] text-slate-400 truncate">
                #ADM-{{ str_pad($currentAdmin->id ?? 1, 4, '0', STR_PAD_LEFT) }}
              </p>
            </div>

            <a href="{{ route('admin.profile') }}" class="px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 flex items-center gap-2.5 transition">
              <i class="fa-regular fa-user text-slate-400"></i>
              <span>My Profile</span>
            </a>

            <div class="border-t border-slate-100 my-1"></div>

            <form action="{{ route('admin.logout') }}" method="POST" class="m-0 p-0">
              @csrf
              <button 
                type="submit" 
                class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 flex items-center gap-2.5 font-medium transition"
              >
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Log Out</span>
              </button>
            </form>
          </div>
        </div>

      </div>
    </header>

    <!-- CONTENT BODY -->
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full space-y-8">

      <!-- Success Flash -->
      @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm">
          <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
          <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
      @endif

      <!-- ផ្នែកទី ១៖ SUNDAY MEETING SCHEDULES -->
      <div class="space-y-4">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Sunday Meetings Schedules</h1>
            <p class="text-xs text-slate-500">កាលវិភាគកម្មវិធីប្រជុំថ្ងៃអាទិត្យ</p>
          </div>
          <button @click="openCreateModal = true" class="bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Add New Meeting</span>
          </button>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-sm overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                <tr>
                  <th class="px-6 py-3.5 text-left">ID</th>
                  <th class="px-6 py-3.5 text-left">Meeting Name</th>
                  <th class="px-6 py-3.5 text-left">Start</th>
                  <th class="px-6 py-3.5 text-left">Stop</th>
                  <th class="px-6 py-3.5 text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse($meetings as $meeting)
                  <tr class="hover:bg-slate-50/70">
                    <td class="px-6 py-3 font-mono text-slate-500">#{{ $meeting->meetting_id }}</td>
                    <td class="px-6 py-3 font-semibold text-slate-800">{{ $meeting->meetting_name }}</td>
                    <td class="px-6 py-3 text-blue-600 font-medium">{{ $meeting->start }}</td>
                    <td class="px-6 py-3 text-slate-600">{{ $meeting->stop }}</td>
                    <td class="px-6 py-3 text-right">
                      <button @click="openEditModal = true; editData = { id: '{{ $meeting->meetting_id }}', name: '{{ $meeting->meetting_name }}', start: '{{ date('Y-m-d\TH:i', strtotime($meeting->start)) }}', stop: '{{ date('Y-m-d\TH:i', strtotime($meeting->stop)) }}' }" class="text-indigo-600 hover:underline mr-3 font-medium">Edit</button>
                      <form action="{{ route('meeting-sunday.destroy', $meeting->meetting_id) }}" method="POST" class="inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:underline font-medium">Delete</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-slate-400">មិនទាន់មានកាលវិភាគប្រជុំទេ។</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <hr class="border-slate-200">

      <!-- ផ្នែកទី ២៖ តារាង STUDENT ATTENDANCE (វត្តមានសិស្ស) -->
      <div class="space-y-4">
        <div>
          <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Student Attendance Records</h2>
          <p class="text-xs text-slate-500">
            កត់ត្រាវត្តមានសិស្សប្រចាំថ្ងៃអាទិត្យ (Absent &ge; 2 ដង ឬ Permission &ge; 4 ដង នឹងលោត<span class="text-red-600 font-bold">ពណ៌ក្រហមព្រមាន</span>)
          </p>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('meeting-sunday.index') }}" class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row gap-3">
          <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរក ID, ឈ្មោះ, លេខទូរស័ព្ទ..." class="w-full rounded-xl border border-slate-300 pl-9 pr-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <select name="dorm_group_id" class="rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white">
            <option value="">All Dorm Groups</option>
            @foreach($groups as $group)
              <option value="{{ $group->id }}" {{ request('dorm_group_id') == $group->id ? 'selected' : '' }}>{{ $group->group_name }}</option>
            @endforeach
          </select>
          <button type="submit" class="px-5 py-2 rounded-xl bg-slate-800 text-white text-sm hover:bg-slate-700 transition">Filter</button>
          <a href="{{ route('meeting-sunday.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 text-sm hover:bg-slate-50 flex items-center justify-center transition">Reset</a>
        </form>

        <!-- Students Attendance Table -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                <tr>
                  <th class="px-4 py-3.5 text-left">Photo</th>
                  <th class="px-4 py-3.5 text-left">Student ID</th>
                  <th class="px-4 py-3.5 text-left">Khmer Name</th>
                  <th class="px-4 py-3.5 text-left">English Name</th>
                  <th class="px-4 py-3.5 text-left">Gender</th>
                  <th class="px-4 py-3.5 text-left">Phone</th>
                  <th class="px-4 py-3.5 text-left">Dorm Group</th>
                  <th class="px-4 py-3.5 text-center">Full Time</th>
                  <th class="px-4 py-3.5 text-center">Absent</th>
                  <th class="px-4 py-3.5 text-center">Permission</th>
                  <th class="px-4 py-3.5 text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse($students as $student)
                  @php
                    $ft = (int)($student->full_time ?? 0);
                    $ab = (int)($student->absent ?? 0);
                    $pm = (int)($student->permission ?? 0);

                    // លក្ខខណ្ឌពណ៌ក្រហម
                    $isAbsentAlert = $ab >= 2;
                    $isPermAlert = $pm >= 4;
                    $hasAlert = $isAbsentAlert || $isPermAlert;
                  @endphp
                  <tr class="hover:bg-slate-50 transition {{ $hasAlert ? 'bg-red-50/20' : '' }}">
                    <!-- Photo -->
                    <td class="px-4 py-3 whitespace-nowrap">
                      @if($student->profile_image)
                        <img src="{{ asset('storage/' . $student->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200" alt="">
                      @else
                        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 text-xs font-bold">N/A</div>
                      @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-semibold text-slate-900">{{ $student->student_ID }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-800">{{ $student->name_khmer }}</td>
                    <td class="px-4 py-3 whitespace-nowrap font-medium text-slate-800">{{ $student->name_english }}</td>
                    <td class="px-4 py-3 whitespace-nowrap capitalize text-slate-600">{{ $student->gender }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-600">{{ $student->phone_number }}</td>
                    <td class="px-4 py-3 whitespace-nowrap font-medium text-blue-600">{{ $student->dormGroup?->group_name ?? '—' }}</td>

                    <!-- Full Time Display -->
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                      <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        {{ $ft }}
                      </span>
                    </td>

                    <!-- Absent Display (ក្រហមបើ >= 2) -->
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                      @if($isAbsentAlert)
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-600 text-white shadow-sm ring-2 ring-red-300 animate-pulse">
                          <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                          {{ $ab }}
                        </span>
                      @else
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                          {{ $ab }}
                        </span>
                      @endif
                    </td>

                    <!-- Permission Display (ក្រហមបើ >= 4) -->
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                      @if($isPermAlert)
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-600 text-white shadow-sm ring-2 ring-red-300 animate-pulse">
                          <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                          {{ $pm }}
                        </span>
                      @else
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                          {{ $pm }}
                        </span>
                      @endif
                    </td>

                    <!-- Actions Button -->
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                      <button 
                        type="button" 
                        @click="openAttendanceModal = true; attendData = {
                          id: '{{ $student->id }}',
                          student_ID: '{{ $student->student_ID }}',
                          name: '{{ $student->name_khmer }} ({{ $student->name_english }})',
                          full_time: {{ $ft }},
                          absent: {{ $ab }},
                          permission: {{ $pm }}
                        }"
                        class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition font-semibold text-xs inline-flex items-center gap-1"
                      >
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>កត់វត្តមាន</span>
                      </button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="11" class="px-6 py-10 text-center text-slate-400">មិនមានទិន្នន័យសិស្សទេ។</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- MODAL: កត់ត្រាតែវត្តមានសិស្ស (Full Time, Absent, Permission) -->
  <div x-show="openAttendanceModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md border border-slate-100" @click.outside="openAttendanceModal = false">
      <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
        <div>
          <h2 class="text-base font-bold text-slate-900">កត់ត្រាវត្តមានសិស្ស</h2>
          <p class="text-xs text-blue-600 font-medium" x-text="attendData.student_ID + ' - ' + attendData.name"></p>
        </div>
        <button @click="openAttendanceModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
      </div>

      <form :action="'/meeting-sunday/students/' + attendData.id + '/attendance'" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Full Time -->
        <div>
          <label class="block text-slate-700 text-xs font-semibold mb-1">Full Time</label>
          <input type="number" name="full_time" x-model="attendData.full_time" min="0" required class="border border-slate-300 rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <!-- Absent -->
        <div>
          <div class="flex justify-between items-center mb-1">
            <label class="block text-slate-700 text-xs font-semibold">Absent (អវត្តមាន)</label>
            <span class="text-[11px] text-red-600 font-medium">&ge; 2 ដង ប្រកាសអាសន្នក្រហម</span>
          </div>
          <input 
            type="number" 
            name="absent" 
            x-model="attendData.absent" 
            min="0" 
            required 
            :class="attendData.absent >= 2 ? 'border-red-500 bg-red-50 text-red-600 font-bold' : 'border-slate-300'"
            class="border rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
          >
          <p x-show="attendData.absent >= 2" class="text-[11px] text-red-600 font-semibold mt-1">
            <i class="fa-solid fa-circle-exclamation"></i> សិស្សនេះអវត្តមាន ២ ដង ឬលើសពីនេះ!
          </p>
        </div>

        <!-- Permission -->
        <div>
          <div class="flex justify-between items-center mb-1">
            <label class="block text-slate-700 text-xs font-semibold">Permission (សុំច្បាប់)</label>
            <span class="text-[11px] text-amber-600 font-medium">&ge; 4 ដង ប្រកាសអាសន្នក្រហម</span>
          </div>
          <input 
            type="number" 
            name="permission" 
            x-model="attendData.permission" 
            min="0" 
            required 
            :class="attendData.permission >= 4 ? 'border-red-500 bg-red-50 text-red-600 font-bold' : 'border-slate-300'"
            class="border rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
          >
          <p x-show="attendData.permission >= 4" class="text-[11px] text-red-600 font-semibold mt-1">
            <i class="fa-solid fa-circle-exclamation"></i> សិស្សនេះសុំច្បាប់ ៤ ដង ឬលើសពីនេះ!
          </p>
        </div>

        <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
          <button type="button" @click="openAttendanceModal = false" class="border border-slate-300 text-slate-700 hover:bg-slate-50 px-4 py-2 rounded-xl text-xs font-medium transition">បោះបង់</button>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-xs font-medium shadow-sm transition">រក្សាទុកវត្តមាន</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL: CREATE MEETING SCHEDULE -->
  <div x-show="openCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md border border-slate-100" @click.outside="openCreateModal = false">
      <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
        <h2 class="text-base font-bold text-slate-900">Create New Meeting</h2>
        <button @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
      </div>
      <form action="{{ route('meeting-sunday.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-slate-700 text-xs font-semibold uppercase mb-1">Meeting Name</label>
          <input type="text" name="meetting_name" required class="border border-slate-300 rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
          <label class="block text-slate-700 text-xs font-semibold uppercase mb-1">Start Time</label>
          <input type="datetime-local" name="start" required class="border border-slate-300 rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
          <label class="block text-slate-700 text-xs font-semibold uppercase mb-1">Stop Time</label>
          <input type="datetime-local" name="stop" required class="border border-slate-300 rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div class="flex justify-end gap-2 pt-2 border-t">
          <button type="button" @click="openCreateModal = false" class="border border-slate-300 px-4 py-2 rounded-xl text-xs">Cancel</button>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-medium">Save Meeting</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL: EDIT MEETING SCHEDULE -->
  <div x-show="openEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md border border-slate-100" @click.outside="openEditModal = false">
      <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
        <h2 class="text-base font-bold text-slate-900">Edit Meeting</h2>
        <button @click="openEditModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
      </div>
      <form :action="'/meeting-sunday/' + editData.id" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
          <label class="block text-slate-700 text-xs font-semibold uppercase mb-1">Meeting Name</label>
          <input type="text" name="meetting_name" x-model="editData.name" required class="border border-slate-300 rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
          <label class="block text-slate-700 text-xs font-semibold uppercase mb-1">Start Time</label>
          <input type="datetime-local" name="start" x-model="editData.start" required class="border border-slate-300 rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
          <label class="block text-slate-700 text-xs font-semibold uppercase mb-1">Stop Time</label>
          <input type="datetime-local" name="stop" x-model="editData.stop" required class="border border-slate-300 rounded-xl w-full py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div class="flex justify-end gap-2 pt-2 border-t">
          <button type="button" @click="openEditModal = false" class="border border-slate-300 px-4 py-2 rounded-xl text-xs">Cancel</button>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-medium">Update Meeting</button>
        </div>
      </form>
    </div>
  </div>

  <!-- JAVASCRIPT LOGIC (Sidebar, Admin Dropdown & Notifications) -->
  <script>
    // --- Mobile Sidebar Toggle ---
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');
    const mainSidebar = document.getElementById('mainSidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    function openSidebar() {
      mainSidebar.classList.remove('-translate-x-full');
      sidebarBackdrop.classList.remove('opacity-0', 'pointer-events-none');
      sidebarBackdrop.classList.add('opacity-100');
      document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
      mainSidebar.classList.add('-translate-x-full');
      sidebarBackdrop.classList.remove('opacity-100');
      sidebarBackdrop.classList.add('opacity-0', 'pointer-events-none');
      document.body.style.overflow = '';
    }

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openSidebar);
    if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
    if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) closeSidebar();
    });

    // --- Admin Dropdown Menu ---
    const adminDropdownTrigger = document.getElementById('adminDropdownTrigger');
    const adminDropdownMenu = document.getElementById('adminDropdownMenu');

    if (adminDropdownTrigger && adminDropdownMenu) {
      adminDropdownTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        adminDropdownMenu.classList.toggle('hidden');
      });

      document.addEventListener('click', (e) => {
        if (!adminDropdownMenu.contains(e.target) && !adminDropdownTrigger.contains(e.target)) {
          adminDropdownMenu.classList.add('hidden');
        }
      });
    }

    // --- Notification Dropdown & Mark As Read Logic (ដូច Dashboard 100%) ---
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifBadge = document.getElementById('notifBadge');

    if (notifBtn && notifDropdown) {
      notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = notifDropdown.classList.contains('hidden');
        notifDropdown.classList.toggle('hidden');

        // ប្រសិនបើបើកមើលដំណឹង ហើយមានលេខ badge បង្ហាញ
        if (isHidden && notifBadge && !notifBadge.classList.contains('hidden')) {
          fetch("{{ route('admin.notifications.markAsRead') }}", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
          })
          .then(res => res.json())
          .then(data => {
            notifBadge.classList.add('hidden');
            notifBadge.innerText = '0';
          })
          .catch(err => console.error(err));
        }
      });

      document.addEventListener('click', (e) => {
        if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
          notifDropdown.classList.add('hidden');
        }
      });
    }
  </script>
</body>
</html>