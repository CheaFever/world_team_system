<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Profile - WT Western Technology</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-[#101c42] text-white flex flex-col justify-between flex-shrink-0 min-h-screen p-5">
    <div class="flex flex-col gap-5">
      <div class="flex items-center gap-3 px-1">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center p-1 font-bold text-slate-900">
          WT
        </div>
        <div>
          <h1 class="text-sm font-bold leading-tight">WT Admin</h1>
          <p class="text-[10px] text-slate-400">Western Technology</p>
        </div>
      </div>

      <nav class="flex flex-col gap-1.5 mt-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-[#1a2c63] text-sm transition">
          <i class="fa-solid fa-house w-4 text-center"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl bg-[#3b82f6] text-white text-sm font-medium shadow-sm transition">
          <i class="fa-regular fa-user w-4 text-center"></i>
          <span>Profile</span>
        </a>
      </nav>
    </div>

    <!-- Bottom Logout -->
    <form action="{{ route('admin.logout') }}" method="POST">
      @csrf
      <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-300 hover:text-white hover:bg-red-500/20 text-sm transition">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
        <span>Logout</span>
      </button>
    </form>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 flex flex-col min-w-0 min-h-screen overflow-y-auto">
    <!-- Header -->
    <header class="w-full bg-white border-b border-slate-200 h-16 flex items-center justify-between px-8 sticky top-0 z-20">
      <div class="flex items-center gap-2 text-sm text-slate-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span>/</span>
        <span class="font-semibold text-slate-800">Admin Profile</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="text-sm font-bold text-slate-800">{{ $admin->full_name ?? $admin->username }}</span>
        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
          <i class="fa-regular fa-user"></i>
        </div>
      </div>
    </header>

    <!-- Profile Body Content -->
    <div class="p-8 max-w-4xl mx-auto w-full space-y-6">
      
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
        <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
          <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-blue-600 to-sky-400 text-white flex items-center justify-center text-2xl font-bold shadow-md">
            <i class="fa-solid fa-user-shield"></i>
          </div>
          <div>
            <h2 class="text-xl font-bold text-slate-900">{{ $admin->full_name ?? 'Administrator' }}</h2>
            <p class="text-xs text-slate-400">Admin ID: #ADM-{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }} • {{ $admin->username }}</p>
          </div>
        </div>

        <!-- FORM UPDATE PROFILE -->
        <form action="{{ route('admin.profile.update') }}" method="POST" class="mt-6 space-y-5">
          @csrf

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

</body>
</html>