<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Admin Dashboard</h1>
        <div class="flex items-center gap-4">
            <span class="text-gray-700">Welcome, <strong>{{ Auth::guard('admin')->user()->full_name }}</strong>!</span>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm font-semibold">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">Your Admin Details:</h3>
        <ul class="space-y-2 text-gray-700">
            <li><strong>Full Name:</strong> {{ Auth::guard('admin')->user()->full_name }}</li>
            <li><strong>Username:</strong> {{ Auth::guard('admin')->user()->username }}</li>
            <li><strong>Gender:</strong> {{ ucfirst(Auth::guard('admin')->user()->gender ?? 'N/A') }}</li>
            <li><strong>DOB:</strong> {{ Auth::guard('admin')->user()->dob ? Auth::guard('admin')->user()->dob->format('Y-m-d') : 'N/A' }}</li>
            <li><strong>Phone:</strong> {{ Auth::guard('admin')->user()->phone ?? 'N/A' }}</li>
            <li><strong>Address:</strong> {{ Auth::guard('admin')->user()->address ?? 'N/A' }}</li>
        </ul>
    </div>
</body>
</html>