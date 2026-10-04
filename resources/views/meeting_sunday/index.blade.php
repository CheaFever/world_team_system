<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Sunday Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for Modals -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> 
</head> 
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen" x-data="{ openCreateModal: false, openEditModal: false, editData: {} }"> 

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10"> 
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8"> 
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">Sunday Meetings</h1> 
                <p class="text-sm text-slate-500 mt-1">Manage schedules, timestamps, and active meeting records.</p>
            </div>
            <button @click="openCreateModal = true" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2.5 rounded-xl shadow-sm transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"> 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add New Meeting 
            </button> 
        </div> 

        <!-- Success Message --> 
        @if(session('success')) 
            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm" role="alert"> 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span> 
            </div> 
        @endif 

        <!-- Error Validation Message --> 
        @if($errors->any()) 
            <div class="flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm"> 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <ul class="list-disc pl-4 text-sm space-y-1"> 
                    @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                    @endforeach 
                </ul> 
            </div> 
        @endif 

        <!-- Table Display --> 
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden"> 
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200"> 
                    <thead class="bg-slate-50/75"> 
                        <tr> 
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th> 
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Meeting Name</th> 
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Start</th> 
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Stop</th> 
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Created At</th> 
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th> 
                        </tr> 
                    </thead> 
                    <tbody class="divide-y divide-slate-200 bg-white"> 
                        @forelse($meetings as $meeting) 
                            <tr class="hover:bg-slate-50/60 transition-colors"> 
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-slate-500">#{{ $meeting->meetting_id }}</td> 
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $meeting->meetting_name }}</td> 
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ $meeting->start }}
                                    </span>
                                </td> 
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $meeting->stop }}
                                    </span>
                                </td> 
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $meeting->create_at }}</td> 
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium"> 
                                    <div class="flex items-center justify-end gap-3">
                                        <!-- Edit Button --> 
                                        <button 
                                            @click="openEditModal = true; editData = { id: '{{ $meeting->meetting_id }}', name: '{{ $meeting->meetting_name }}', start: '{{ date('Y-m-d\TH:i', strtotime($meeting->start)) }}', stop: '{{ date('Y-m-d\TH:i', strtotime($meeting->stop)) }}' }" 
                                            class="text-indigo-600 hover:text-indigo-900 transition-colors">Edit</button> 
         
                                        <!-- Delete Form --> 
                                        <form action="{{ route('meeting-sunday.destroy', $meeting->meetting_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this meeting?');"> 
                                            @csrf 
                                            @method('DELETE') 
                                            <button type="submit" class="text-rose-600 hover:text-rose-900 transition-colors">Delete</button> 
                                        </form> 
                                    </div>
                                </td> 
                            </tr> 
                        @empty 
                            <tr> 
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm font-medium text-slate-600">No meetings found.</p>
                                        <p class="text-xs text-slate-400 mt-1">Get started by creating your first Sunday meeting schedule.</p>
                                    </div>
                                </td> 
                            </tr> 
                        @endforelse 
                    </tbody> 
                </table> 
            </div>
        </div> 

        <!-- Create Modal --> 
        <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4" style="display: none;" x-transition.opacity> 
            <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md border border-slate-100" @click.outside="openCreateModal = false"> 
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Create New Meeting</h2> 
                    <button @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('meeting-sunday.store') }}" method="POST"> 
                    @csrf 
                    <div class="mb-4"> 
                        <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">Meeting Name</label> 
                        <input type="text" name="meetting_name" required placeholder="e.g. Morning Worship Service" class="border border-slate-300 rounded-xl w-full py-2.5 px-3 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"> 
                    </div> 
                    <div class="mb-4"> 
                        <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">Start Time</label> 
                        <input type="datetime-local" name="start" required class="border border-slate-300 rounded-xl w-full py-2.5 px-3 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"> 
                    </div> 
                    <div class="mb-6"> 
                        <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">Stop Time</label> 
                        <input type="datetime-local" name="stop" required class="border border-slate-300 rounded-xl w-full py-2.5 px-3 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"> 
                    </div> 
                    <div class="flex justify-end gap-3"> 
                        <button type="button" @click="openCreateModal = false" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">Cancel</button> 
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium shadow-sm transition-colors">Save Meeting</button> 
                    </div> 
                </form> 
            </div> 
        </div> 

        <!-- Edit Modal --> 
        <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4" style="display: none;" x-transition.opacity> 
            <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md border border-slate-100" @click.outside="openEditModal = false"> 
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Edit Meeting</h2> 
                    <button @click="openEditModal = false" class="text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <form :action="'/meeting-sunday/' + editData.id" method="POST"> 
                    @csrf 
                    @method('PUT') 
                    <div class="mb-4"> 
                        <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">Meeting Name</label> 
                        <input type="text" name="meetting_name" x-model="editData.name" required class="border border-slate-300 rounded-xl w-full py-2.5 px-3 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"> 
                    </div> 
                    <div class="mb-4"> 
                        <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">Start Time</label> 
                        <input type="datetime-local" name="start" x-model="editData.start" required class="border border-slate-300 rounded-xl w-full py-2.5 px-3 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"> 
                    </div> 
                    <div class="mb-6"> 
                        <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">Stop Time</label> 
                        <input type="datetime-local" name="stop" x-model="editData.stop" required class="border border-slate-300 rounded-xl w-full py-2.5 px-3 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"> 
                    </div> 
                    <div class="flex justify-end gap-3"> 
                        <button type="button" @click="openEditModal = false" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">Cancel</button> 
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium shadow-sm transition-colors">Update Meeting</button> 
                    </div> 
                </form> 
            </div> 
        </div> 

    </div> 
</body> 
</html>