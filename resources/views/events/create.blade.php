<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
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
    <div class="max-w-3xl mx-auto">
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            
            <!-- Header Section -->
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 text-white flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Create New Event</h1>
                    <p class="text-indigo-100 text-sm mt-1">Fill in the details below to publish your event</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-xl">
                    <i class="fa-regular fa-calendar-plus"></i>
                </div>
            </div>

            <!-- Error Notification -->
            @if ($errors->any())
                <div class="mx-8 mt-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>There were errors with your submission:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-rose-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <!-- Event Type & Date Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Event Type <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fa-solid fa-tag text-sm"></i>
                            </span>
                            <input type="text" name="type_of_event" value="{{ old('type_of_event') }}" required 
                                   placeholder="e.g. Technology Seminar"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-150">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Event Date <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fa-regular fa-calendar text-sm"></i>
                            </span>
                            <input type="date" name="event_date" value="{{ old('event_date') }}" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-150">
                        </div>
                    </div>
                </div>

                <!-- Start & End Time Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Start Time <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fa-regular fa-clock text-sm"></i>
                            </span>
                            <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" max="2099-12-31T23:59" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-150">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            End Time <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fa-regular fa-clock text-sm"></i>
                            </span>
                            <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" max="2099-12-31T23:59" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-150">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="4" placeholder="Write a short summary about the event..."
                              class="w-full p-4 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-150">{{ old('description') }}</textarea>
                </div>

                <!-- Image Upload with Drag & Drop Preview -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Event Banner / Image</label>
                    <div class="relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition cursor-pointer"
                         onclick="document.getElementById('imageInput').click()">
                        
                        <div id="uploadPlaceholder" class="flex flex-col items-center">
                            <div class="h-12 w-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-2">
                                <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">Click to upload an image</p>
                            <p class="text-xs text-slate-400 mt-1">PNG, JPG, or WEBP up to 2MB</p>
                        </div>

                        <!-- Image Preview -->
                        <img id="imagePreview" src="#" alt="Preview" class="hidden h-36 w-full object-cover rounded-xl mt-2 border border-slate-200 shadow-sm" />

                        <input id="imageInput" type="file" name="image" accept="image/*" class="hidden" onchange="previewFile(event)">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('events.index') }}" 
                       class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-200 transition duration-200 flex items-center gap-2">
                        <i class="fa-regular fa-floppy-disk"></i>
                        Save Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script for Live Image Preview -->
    <script>
        function previewFile(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>