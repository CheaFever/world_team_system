<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WT World Team Dom Dorm Groups Management</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
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
  </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex overflow-x-hidden">

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

  <!-- SIDEBAR -->
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

        <!-- Dorm Groups (ACTIVE / ភ្លឺ) -->
        <a href="{{ route('admin.dorm-groups.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl bg-[#3b82f6] text-white text-sm font-semibold shadow-sm transition">
          <i class="fa-solid fa-bed w-4 text-center"></i>
          <span>Dorm Groups</span>
        </a>

        <!-- Student Information -->
        <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
          <i class="fa-solid fa-users w-4 text-center"></i>
          <span>Student Information</span>
        </a>

        <!-- Meeting of Sunday -->
        <a href="{{ route('meeting-sunday.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
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
    
    <!-- TOP NAVIGATION BAR -->
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
          <i class="fa-solid fa-bed text-blue-600"></i>
          <span class="text-sm font-bold text-slate-800">Dormitory Groups Management</span>
        </div>
      </div>

      <!-- Right: Notifications & Admin Profile Section -->
      <div class="flex items-center gap-3 sm:gap-5">
        
        <!-- NOTIFICATION SECTION -->
        <div class="relative">
          <button 
            id="notifBtn" 
            class="relative text-slate-600 hover:text-slate-900 transition p-2 rounded-full hover:bg-slate-50 focus:outline-none" 
            aria-label="Notifications"
          >
            <i class="fa-regular fa-bell text-base sm:text-lg"></i>
            
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
            <!-- Dynamic Profile Avatar -->
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

            <!-- Admin Information -->
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

    <!-- DORM GROUPS MAIN BODY CONTENT -->
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full space-y-6">

      <!-- Header: Title & Action Button -->
      <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
          <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Dormitory Groups</h2>
          <p class="text-xs sm:text-sm text-slate-500 mt-1">Manage dorm groups, rooms, and capacities in one place.</p>
        </div>
        <div class="flex gap-2">
          <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm font-medium hover:bg-slate-50 transition shadow-sm">
            ← Dashboard
          </a>
          <button type="button" onclick="openCreateModal()" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium shadow-sm transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>New Group</span>
          </button>
        </div>
      </div>

      <!-- Flash Alerts -->
      @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center justify-between shadow-sm">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
        </div>
      @endif

      @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-sm shadow-sm">
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Groups Table -->
      <div class="bg-white border border-slate-200/90 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
              <tr>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase">Group Name</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase">Room</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase">Capacity</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase">Current Students</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                <th class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @forelse($groups as $group)
                <tr class="hover:bg-slate-50/80 transition">
                  <td class="px-6 py-4 text-sm font-semibold text-slate-900">#{{ $group->id }}</td>
                  <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $group->group_name }}</td>
                  <td class="px-6 py-4 text-sm text-slate-600">{{ $group->room_number ?? '—' }}</td>
                  <td class="px-6 py-4 text-sm text-slate-600">{{ $group->maximum_capacity }}</td>
                  <td class="px-6 py-4 text-sm font-medium text-blue-600">
                    {{ $group->students()->count() }} / {{ $group->maximum_capacity }}
                  </td>
                  <td class="px-6 py-4 text-sm">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $group->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                      {{ ucfirst($group->status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-center">
                    <div class="flex items-center justify-center gap-3">
                      <button type="button" onclick="openShowModal({{ json_encode($group) }}, {{ $group->students()->count() }})" class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                        View
                      </button>
                      <button type="button" onclick="openEditModal({{ json_encode($group) }})" class="text-amber-600 hover:text-amber-800 font-medium hover:underline">
                        Edit
                      </button>
                      <form action="{{ route('admin.dorm-groups.destroy', $group) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុប Dorm Group នេះមែនទេ?');" class="inline">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium hover:underline">
                          Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                    <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                    No groups found.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>

  {{-- ========================================================= --}}
  {{-- 1. CREATE MODAL                                           --}}
  {{-- ========================================================= --}}
  <div id="createModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <h3 class="text-base font-bold text-slate-900">Add New Dorm Group</h3>
        <button onclick="closeModal('createModal')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
      </div>
      
      <form action="{{ route('admin.dorm-groups.store') }}" method="POST" class="p-6 space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Group Name *</label>
          <input type="text" name="group_name" required placeholder="ឧ. Dorm A-01" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Room Number</label>
          <input type="text" name="room_number" placeholder="ឧ. 101" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Maximum Capacity *</label>
          <input type="number" name="maximum_capacity" required min="1" value="4" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Status *</label>
          <select name="status" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
          <button type="button" onclick="closeModal('createModal')" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm hover:bg-slate-50 transition">Cancel</button>
          <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-xs transition">Save Group</button>
        </div>
      </form>
    </div>
  </div>

  {{-- ========================================================= --}}
  {{-- 2. EDIT MODAL                                             --}}
  {{-- ========================================================= --}}
  <div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <h3 class="text-base font-bold text-slate-900">Edit Dorm Group</h3>
        <button onclick="closeModal('editModal')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
      </div>
      
      <form id="editForm" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Group Name *</label>
          <input type="text" id="edit_group_name" name="group_name" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Room Number</label>
          <input type="text" id="edit_room_number" name="room_number" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Maximum Capacity *</label>
          <input type="number" id="edit_maximum_capacity" name="maximum_capacity" required min="1" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">Status *</label>
          <select id="edit_status" name="status" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-amber-500 bg-white">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
          <button type="button" onclick="closeModal('editModal')" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm hover:bg-slate-50 transition">Cancel</button>
          <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold shadow-xs transition">Update Group</button>
        </div>
      </form>
    </div>
  </div>

  {{-- ========================================================= --}}
  {{-- 3. SHOW / VIEW MODAL                                      --}}
  {{-- ========================================================= --}}
  <div id="showModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden p-6">
      <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
        <h3 class="text-base font-bold text-slate-900">Dorm Group Details</h3>
        <button onclick="closeModal('showModal')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
      </div>

      <div class="bg-slate-50 p-4 rounded-xl space-y-3 border border-slate-100 text-sm">
        <div class="flex justify-between">
          <span class="text-slate-500">Group ID:</span>
          <span id="show_id" class="font-bold text-slate-900"></span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Group Name:</span>
          <span id="show_name" class="font-bold text-blue-600"></span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Room Number:</span>
          <span id="show_room" class="font-semibold text-slate-800"></span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Capacity:</span>
          <span id="show_capacity" class="font-semibold text-slate-800"></span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Current Occupancy:</span>
          <span id="show_students" class="font-bold text-emerald-600"></span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Status:</span>
          <span id="show_status" class="capitalize font-semibold"></span>
        </div>
      </div>

      <div class="flex justify-end mt-6">
        <button type="button" onclick="closeModal('showModal')" class="px-6 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-sm font-semibold transition">
          Close
        </button>
      </div>
    </div>
  </div>

  <!-- JAVASCRIPT LOGIC -->
  <script>
    // --- Mobile Sidebar Toggle Logic ---
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

    // --- Admin Dropdown Toggle ---
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

    // --- Notification Dropdown & Mark as Read Logic ---
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifBadge = document.getElementById('notifBadge');

    if (notifBtn && notifDropdown) {
      notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = notifDropdown.classList.contains('hidden');
        notifDropdown.classList.toggle('hidden');

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

    // --- Modal Logic ---
    function openCreateModal() {
      document.getElementById('createModal').classList.remove('hidden');
    }

    function openEditModal(group) {
      document.getElementById('editForm').action = '/admin/dorm-groups/' + group.id;
      document.getElementById('edit_group_name').value = group.group_name || '';
      document.getElementById('edit_room_number').value = group.room_number || '';
      document.getElementById('edit_maximum_capacity').value = group.maximum_capacity || 1;
      document.getElementById('edit_status').value = group.status || 'active';

      document.getElementById('editModal').classList.remove('hidden');
    }

    function openShowModal(group, currentCount) {
      document.getElementById('show_id').innerText = '#' + group.id;
      document.getElementById('show_name').innerText = group.group_name || '—';
      document.getElementById('show_room').innerText = group.room_number || '—';
      document.getElementById('show_capacity').innerText = group.maximum_capacity + ' នាក់';
      document.getElementById('show_students').innerText = currentCount + ' / ' + group.maximum_capacity + ' នាក់';
      document.getElementById('show_status').innerText = group.status || '—';

      document.getElementById('showModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
      document.getElementById(modalId).classList.add('hidden');
    }

    window.onclick = function(e) {
      ['createModal', 'editModal', 'showModal'].forEach(id => {
        const modal = document.getElementById(id);
        if (e.target === modal) {
          modal.classList.add('hidden');
        }
      });
    };
  </script>
</body>
</html>