<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WT Western Technology - Dashboard</title>
  
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
    .stat-blue-gradient {
      background: linear-gradient(135deg, #4d8fe4 0%, #306ec4 100%);
    }
    .stat-purple-gradient {
      background: linear-gradient(135deg, #8952cc 0%, #b84cb5 100%);
    }
  </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex overflow-x-hidden">

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
      
      <!-- Brand Logo, Name & Interactive Image Changer -->
      <div class="flex items-center justify-between px-1 pt-1">
        <div class="flex items-center gap-3">
          <!-- Logo container with file picker -->
          <div class="relative group cursor-pointer" title="ចុចដើម្បីប្តូរ Logo">
            <input 
              type="file" 
              id="logoFileInput" 
              accept="image/*" 
              class="hidden" 
            />
            <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center p-0.5 shadow-sm overflow-hidden border-2 border-white/80 group-hover:border-blue-400 transition-all">
              <img 
                id="schoolLogoImg" 
                src="{{ asset('images/Logo WT.png') }}" 
                alt="WT Logo" 
                class="w-full h-full object-cover rounded-full"
                onerror="this.onerror=null; this.src='https://placehold.co/100x100/101c42/ffffff?text=WT';"
              />
            </div>
            <div class="absolute -bottom-1 -right-1 bg-blue-500 hover:bg-blue-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[9px] shadow border border-[#101c42]">
              <i class="fa-solid fa-camera"></i>
            </div>
          </div>

          <div>
            <div class="flex items-center gap-1.5">
              <h1 class="text-sm font-bold tracking-wide leading-tight text-white">WT</h1>
            </div>
            <p class="text-[13px] font-semibold text-slate-100 leading-tight">Western Technology</p>
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
        <!-- Dashboard (Active) -->
        <a href="#" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl bg-[#3b82f6] text-white text-sm font-medium shadow-sm transition">
          <i class="fa-solid fa-house w-4 text-center"></i>
          <span>Dashboard</span>
        </a>

        <!-- Profile -->
      <a href="{{ route('admin.profile') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm transition">
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
        <a href="#" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm font-normal transition duration-150">
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
      
      <!-- Left: Mobile Menu Toggle & Search Bar -->
      <div class="flex items-center gap-3 flex-1 max-w-md">
        <button 
          id="mobileMenuBtn" 
          class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 focus:outline-none transition active:scale-95"
          aria-label="Open Navigation Menu"
        >
          <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <div class="relative w-full max-w-xs sm:max-w-sm">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
          </span>
          <input 
            type="text" 
            placeholder="Search..." 
            class="w-full pl-9 pr-4 py-2 bg-[#f0f4f9] text-xs sm:text-sm text-slate-700 rounded-full border-none focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-slate-400 transition"
          />
        </div>
      </div>

      <!-- Right: Notifications & Admin Profile Section -->
      <div class="flex items-center gap-3 sm:gap-5">
        <!-- Notification icon -->
        <button class="relative text-slate-600 hover:text-slate-900 transition p-2 rounded-full hover:bg-slate-50" aria-label="Notifications">
          <i class="fa-regular fa-bell text-base sm:text-lg"></i>
          <span class="absolute top-1 right-1 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border-2 border-white">
            0
          </span>
        </button>

        <!-- Hidden Input សម្រាប់ Upload រូបភាព Admin Profile -->
        <input type="file" id="adminProfileFileInput" accept="image/*" class="hidden">

        <!-- Admin Profile Dropdown Button -->
        <div class="relative">
          <div 
            id="adminDropdownTrigger" 
            class="flex items-center gap-2.5 cursor-pointer group p-1.5 rounded-full hover:bg-slate-100 transition select-none"
          >
            <!-- Profile Avatar with Camera Icon Overlay -->
            <div 
              class="relative w-9 h-9 rounded-full ring-2 ring-blue-500/30 overflow-hidden bg-slate-200 flex items-center justify-center shadow-inner group-hover:ring-blue-500 transition"
              title="ចុចត្រង់នេះដើម្បីប្តូររូបភាព Profile (Click to change avatar)"
              onclick="event.stopPropagation(); document.getElementById('adminProfileFileInput').click();"
            >
              <img 
                id="adminProfileImg" 
                src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&auto=format&fit=crop&q=80" 
                alt="Admin Photo" 
                class="w-full h-full object-cover"
                onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
              />
              <div class="hidden w-full h-full bg-slate-200 text-slate-600 flex items-center justify-center text-sm font-semibold">
                <i class="fa-solid fa-user"></i>
              </div>

              <!-- Camera Badge hover -->
              <div class="absolute inset-0 bg-black/40 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-150">
                <i class="fa-solid fa-camera text-[10px]"></i>
              </div>
            </div>

            <!-- Admin Real Name from Laravel Session/Auth -->
            <div class="hidden sm:flex flex-col text-left">
              <span class="text-xs sm:text-sm font-bold text-slate-800 leading-tight">
                {{ Auth::user()->name ?? Auth::user()->username ?? session('username') ?? 'Admin' }}
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
                {{ Auth::user()->name ?? Auth::user()->username ?? session('username') ?? 'Admin' }}
              </p>
              <p class="text-[11px] text-slate-400 truncate">
                {{ Auth::user()->email ?? 'admin@wt.edu.kh' }}
              </p>
            </div>

            <button 
              type="button" 
              onclick="document.getElementById('adminProfileFileInput').click();"
              class="w-full text-left px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 flex items-center gap-2.5 transition"
            >
              <i class="fa-solid fa-camera text-blue-500"></i>
              <span>Change Profile Picture</span>
            </button>

           <a href="{{ route('admin.profile') }}" class="px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 flex items-center gap-2.5 transition">
  <i class="fa-regular fa-user text-slate-400"></i>
  <span>My Profile</span>
</a>

            <div class="border-t border-slate-100 my-1"></div>

            <!-- Logout Route -->
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

    <!-- DASHBOARD BODY CONTENT -->
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full space-y-6">

      <!-- Header: Title & Date Widget -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Dashboard</h2>
          <!-- Show Logged In Name -->
          <p class="text-sm sm:text-base font-semibold text-slate-800 mt-0.5 sm:mt-1">
            Welcome back, <span class="text-blue-600 font-bold">{{ Auth::user()->name ?? Auth::user()->username ?? session('username') ?? 'Admin' }}</span>!
          </p>
          <p class="text-xs text-slate-400 mt-0.5">Here is an overview of your system.</p>
        </div>

        <!-- Date Card Widget -->
        <div class="bg-white border border-slate-200/90 rounded-2xl px-4 sm:px-5 py-2.5 sm:py-3 flex items-center gap-3.5 shadow-sm self-start sm:self-auto">
          <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm sm:text-base">
            <i class="fa-regular fa-calendar"></i>
          </div>
          <div>
            <p class="text-[11px] font-medium text-slate-400">Today</p>
            <p class="text-xs sm:text-sm font-bold text-slate-800" id="currentDateDisplay">October 1, 2026</p>
          </div>
        </div>
      </div>

      <!-- STAT CARDS -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        
        <!-- Total Students Card -->
        <div class="stat-blue-gradient text-white rounded-2xl p-5 sm:p-6 shadow-sm flex items-center justify-between relative overflow-hidden transition transform hover:-translate-y-0.5 duration-200">
          <div class="flex items-center gap-4 z-10">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/20 flex items-center justify-center text-white backdrop-blur-sm shadow-inner flex-shrink-0">
              <i class="fa-solid fa-users text-lg sm:text-xl"></i>
            </div>
            <div>
              <p class="text-sm font-medium text-blue-100">Total Students</p>
              <div class="w-10 h-1 bg-white/60 rounded-full my-1.5"></div>
              <p class="text-xs text-blue-100/90 font-light">Student information</p>
            </div>
          </div>
        </div>

        <!-- Total Events Card -->
        <div class="stat-purple-gradient text-white rounded-2xl p-5 sm:p-6 shadow-sm flex items-center justify-between relative overflow-hidden transition transform hover:-translate-y-0.5 duration-200">
          <div class="flex items-center gap-4 z-10">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/20 flex items-center justify-center text-white backdrop-blur-sm shadow-inner flex-shrink-0">
              <i class="fa-regular fa-calendar-check text-lg sm:text-xl"></i>
            </div>
            <div>
              <p class="text-sm font-medium text-purple-100">Total Events</p>
              <div class="w-10 h-1 bg-white/60 rounded-full my-1.5"></div>
              <p class="text-xs text-purple-100/90 font-light">Event information</p>
            </div>
          </div>
        </div>

      </div>

      <!-- LOWER SECTION: RECENT EVENTS & QUICK ACTIONS -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Events (Span 2) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 flex flex-col justify-between shadow-sm min-h-[280px] sm:min-h-[320px]">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-slate-800 font-semibold text-sm">
              <i class="fa-regular fa-calendar text-slate-700"></i>
              <span>Recent Events</span>
            </div>
            <a href="#" class="text-xs text-slate-400 hover:text-blue-600 font-normal transition">View All</a>
          </div>

          <!-- Empty State -->
          <div class="flex flex-col items-center justify-center py-10 sm:py-14 text-center my-auto">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mb-3 shadow-inner">
              <i class="fa-regular fa-calendar-xmark text-2xl"></i>
            </div>
            <h4 class="text-sm font-bold text-slate-700">No Events Yet</h4>
            <p class="text-xs text-slate-400 mt-1 max-w-xs px-2">Events will appear here when they are created.</p>
          </div>
        </div>

        <!-- Quick Actions (Span 1) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-sm flex flex-col">
          <h3 class="text-sm font-bold text-slate-800 mb-4 sm:mb-5">Quick Actions</h3>
          
          <div class="flex flex-col gap-3">
            <button class="w-full bg-[#4f86e9] hover:bg-[#3d75db] text-white py-2.5 px-4 rounded-xl flex items-center gap-3 text-xs font-semibold shadow-sm transition active:scale-[0.98]">
              <i class="fa-solid fa-user-plus text-sm"></i>
              <span>Add New Student</span>
            </button>

            <button class="w-full bg-[#5fa879] hover:bg-[#509669] text-white py-2.5 px-4 rounded-xl flex items-center gap-3 text-xs font-semibold shadow-sm transition active:scale-[0.98]">
              <i class="fa-regular fa-calendar-plus text-sm"></i>
              <span>Create Event</span>
            </button>

            <button class="w-full bg-[#c86161] hover:bg-[#b54f4f] text-white py-2.5 px-4 rounded-xl flex items-center gap-3 text-xs font-semibold shadow-sm transition active:scale-[0.98]">
              <i class="fa-regular fa-file-pdf text-sm"></i>
              <span>Export PDF</span>
            </button>

            <button class="w-full bg-[#8c52d6] hover:bg-[#7b40c6] text-white py-2.5 px-4 rounded-xl flex items-center gap-3 text-xs font-semibold shadow-sm transition active:scale-[0.98]">
              <i class="fa-regular fa-file-excel text-sm"></i>
              <span>Export Excel</span>
            </button>
          </div>
        </div>

      </div>

      <!-- BOTTOM QUOTE BANNER -->
      <div class="bg-white border border-slate-200/90 rounded-2xl p-4 flex items-center gap-3 shadow-sm">
        <i class="fa-solid fa-graduation-cap text-lg text-slate-800 pl-2"></i>
        <span class="text-xs sm:text-sm font-semibold text-slate-700 tracking-wide">
          &ldquo;Better Students, Brighter Future&rdquo;
        </span>
      </div>

    </div>
  </main>

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

    // --- Interactive Admin Profile Upload & Preview ---
    const adminProfileFileInput = document.getElementById('adminProfileFileInput');
    const adminProfileImg = document.getElementById('adminProfileImg');

    if (adminProfileFileInput && adminProfileImg) {
      adminProfileFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(event) {
            adminProfileImg.src = event.target.result;
            adminProfileImg.style.display = 'block';
            
            // រក្សាទុករូបភាពក្នុង LocalStorage សម្រាប់មើលភ្លាមៗ
            try {
              localStorage.setItem('adminCustomAvatar', event.target.result);
            } catch (err) {
              console.log('Avatar image storage limit reached');
            }
          };
          reader.readAsDataURL(file);
        }
      });

      // Load avatar ពី LocalStorage បើធ្លាប់ Upload
      const savedAvatar = localStorage.getItem('adminCustomAvatar');
      if (savedAvatar) {
        adminProfileImg.src = savedAvatar;
      }
    }

    // --- Logo Image Changer Logic ---
    const logoContainer = document.querySelector('.group.cursor-pointer');
    const logoFileInput = document.getElementById('logoFileInput');
    const schoolLogoImg = document.getElementById('schoolLogoImg');

    if (logoContainer && logoFileInput) {
      logoContainer.addEventListener('click', () => logoFileInput.click());
      logoFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(event) {
            schoolLogoImg.src = event.target.result;
            try {
              localStorage.setItem('customSchoolLogo', event.target.result);
            } catch (err) {}
          };
          reader.readAsDataURL(file);
        }
      });

      const savedLogo = localStorage.getItem('customSchoolLogo');
      if (savedLogo) schoolLogoImg.src = savedLogo;
    }
  </script>
</body>
</html>