<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Profile - WT World Team Dom</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <style>
    body { font-family: 'Inter', sans-serif; }
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
  </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex overflow-x-hidden">

  @php
    $currentAdmin = Auth::guard('admin')->user() ?? $admin;
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

        <!-- Profile (Active) -->
        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl bg-[#3b82f6] text-white text-sm font-medium shadow-sm transition">
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

        <!-- Meeting of Sunday -->
        <a href="{{ route('meeting-sunday.index') }}"class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
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

  <!-- MAIN CONTENT -->
  <main class="flex-1 flex flex-col min-w-0 min-h-screen overflow-y-auto w-full">
    <!-- Header -->
    <header class="w-full bg-white border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
      <div class="flex items-center gap-3">
        <button 
          id="mobileMenuBtn" 
          class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 focus:outline-none transition active:scale-95"
          aria-label="Open Navigation Menu"
        >
          <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-600">
          <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
          <span>/</span>
          <span class="font-semibold text-slate-800">Admin Profile</span>
        </div>
      </div>

      <!-- Right Actions: Notifications & Admin Dropdown -->
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
            <div class="w-9 h-9 rounded-full ring-2 ring-blue-500/30 overflow-hidden bg-slate-200 flex items-center justify-center shadow-inner group-hover:ring-blue-500 transition">
              @if($admin->image && file_exists(public_path('uploads/admins/' . $admin->image)))
                <img 
                  src="{{ asset('uploads/admins/' . $admin->image) }}" 
                  alt="Admin Photo" 
                  class="w-full h-full object-cover"
                />
              @else
                <div class="w-full h-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                  {{ strtoupper(substr($admin->username ?? 'A', 0, 1)) }}
                </div>
              @endif
            </div>

            <div class="hidden sm:flex flex-col text-left">
              <span class="text-xs sm:text-sm font-bold text-slate-800 leading-tight">
                {{ $admin->full_name ?? $admin->username ?? 'Administrator' }}
              </span>
              <span class="text-[10px] text-slate-400 font-medium">Administrator</span>
            </div>

            <i class="fa-solid fa-chevron-down text-[10px] text-slate-500 ml-0.5"></i>
          </div>

          <!-- Profile Dropdown Menu -->
          <div 
            id="adminDropdownMenu" 
            class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 transition-all duration-200"
          >
            <div class="px-4 py-2 border-b border-slate-100">
              <p class="text-xs font-semibold text-slate-800 truncate">
                {{ $admin->full_name ?? $admin->username ?? 'Administrator' }}
              </p>
              <p class="text-[11px] text-slate-400 truncate">
                #ADM-{{ str_pad($admin->id ?? 1, 4, '0', STR_PAD_LEFT) }}
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

    <!-- Profile Body Content -->
    <div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto w-full space-y-6">
      
      @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
          <i class="fa-solid fa-circle-check"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        
        <!-- FORM UPDATE PROFILE -->
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf

          <!-- Profile Header with Image Upload Preview -->
          <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pb-6 border-b border-slate-100">
            <div class="relative group">
              @if($admin->image && file_exists(public_path('uploads/admins/' . $admin->image)))
                <img id="preview-image" src="{{ asset('uploads/admins/' . $admin->image) }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-2 border-blue-500 shadow-md">
              @else
                <img id="preview-image" src="https://ui-avatars.com/api/?name={{ urlencode($admin->full_name ?? $admin->username) }}&background=2563eb&color=fff&size=128" alt="Profile" class="w-24 h-24 rounded-full object-cover border-2 border-blue-500 shadow-md">
              @endif

              <!-- Camera Badge Trigger Button -->
              <label for="image-upload" class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center shadow-lg cursor-pointer transition">
                <i class="fa-solid fa-camera text-xs"></i>
                <input type="file" id="image-upload" name="image" class="hidden" accept="image/*" onchange="previewFile(event)">
              </label>
            </div>

            <div class="text-center sm:text-left flex-1">
              <h2 class="text-xl font-bold text-slate-900">{{ $admin->full_name ?? 'Administrator' }}</h2>
              <p class="text-xs text-slate-400 mt-0.5">Admin ID: #ADM-{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }} • {{ $admin->username }}</p>
              
              <div class="mt-3">
                <label for="image-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg cursor-pointer transition">
                  <i class="fa-solid fa-arrow-up-from-bracket text-[11px]"></i> ផ្លាស់ប្តូររូបថត Profile
                </label>
                <p class="text-[11px] text-slate-400 mt-1">គាំទ្រ JPEG, PNG, JPG, WEBP (អតិបរមា 2MB)</p>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Full Name -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Full Name (ឈ្មោះពេញ)</label>
              <input type="text" name="full_name" value="{{ old('full_name', $admin->full_name) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Username -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Username (ឈ្មោះចូលប្រើ)</label>
              <input type="text" name="username" value="{{ old('username', $admin->username) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Phone Number (លេខទូរស័ព្ទ)</label>
              <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Gender -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Gender (ភេទ)</label>
              <select name="gender" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">ជ្រើសរើសភេទ</option>
                <option value="male" {{ old('gender', $admin->gender) == 'male' ? 'selected' : '' }}>Male (ប្រុស)</option>
                <option value="female" {{ old('gender', $admin->gender) == 'female' ? 'selected' : '' }}>Female (ស្រី)</option>
                <option value="other" {{ old('gender', $admin->gender) == 'other' ? 'selected' : '' }}>Other (ផ្សេងៗ)</option>
              </select>
            </div>

            <!-- Date of Birth -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Date of Birth (ថ្ងៃខែឆ្នាំកំណើត)</label>
              <input type="date" name="dob" value="{{ old('dob', $admin->dob) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Address -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Address (អាសយដ្ឋាន)</label>
              <input type="text" name="address" value="{{ old('address', $admin->address) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
          </div>

          <!-- Change Password Section -->
          <div class="pt-4 border-t border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-3"><i class="fa-solid fa-lock text-slate-400 mr-1.5"></i> Change Password (ទុកទំនេរបើមិនចង់ប្តូរពាក្យសម្ងាត់)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">New Password</label>
                <input type="password" name="password" placeholder="បញ្ចូល Password ថ្មីយ៉ាងតិច ៦ ខ្ទង់" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="បញ្ជាក់ Password ថ្មីម្ដងទៀត" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end gap-3 pt-3">
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition">បោះបង់</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
              <i class="fa-solid fa-floppy-disk mr-1.5"></i> រក្សាទុកការផ្លាស់ប្តូរ
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script>
    // Preview Image Logic
    function previewFile(event) {
      const file = event.target.files[0];
      if (file) {
        const preview = document.getElementById('preview-image');
        preview.src = URL.createObjectURL(file);
      }
    }

    // Mobile Sidebar Toggle Logic
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

    // Admin Dropdown Toggle
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

    // Notification Dropdown & Mark as Read Logic
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
  </script>

</body>
</html>