<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * បង្ហាញបញ្ជី Events ទាំងអស់
     */
    public function index()
    {
        $events = Event::with('creator')->latest('event_ID')->paginate(10);
        return view('events.index', compact('events'));
    }

    /**
     * បង្ហាញ Form សម្រាប់បង្កើត Event ថ្មី
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * រក្សាទុកទិន្នន័យ Event ថ្មីចូលទៅកាន់ Database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_of_event' => 'required|string|max:150',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after:start_time',
            'event_date'    => 'required|date',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload រូបភាពប្រសិនបើមាន
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        // ចាប់យក ID របស់អ្នកបង្កើត (Admin / User បច្ចុប្បន្ន)
        $validated['created_by'] = Auth::id() ?? 1; // ដាក់ default 1 ប្រសិនបើមិនទាន់បាន login

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event ត្រូវបានបង្កើតដោយជោគជ័យ!');
    }

    /**
     * បង្ហាញព័ត៌មានលម្អិតរបស់ Event មួយ
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * បង្ហាញ Form កែប្រែទិន្នន័យ Event
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * កែប្រែទិន្នន័យ Event នៅក្នុង Database
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'type_of_event' => 'required|string|max:150',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after:start_time',
            'event_date'    => 'required|date',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // ប្រសិនបើមានការប្តូររូបភាពថ្មី
        if ($request->hasFile('image')) {
            // លុបរូបភាពចាស់ចេញ
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event ត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    /**
     * លុប Event ចេញពី Database
     */
    public function destroy(Event $event)
    {
        // លុបរូបភាពចេញពី storage
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event ត្រូវបានលុបដោយជោគជ័យ!');
    }
}