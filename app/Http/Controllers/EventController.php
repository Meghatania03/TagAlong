<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    // All events (main feed)
    public function index()
    {
        $events = Event::withCount('interestedUsers')->with('user')->latest()->get();
        return view('events.all', compact('events'));
    }

    // Events created by logged-in user
    public function myEvents()
    {
        $events = Event::where('user_id', Auth::id())->latest()->get();
        return view('events.my', compact('events'));
    }

    // Events the user marked interested
    public function interested()
    {
        $events = Auth::user()->interestedEvents()->latest()->get();
        return view('events.interested', compact('events'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Optional: check if the authenticated user owns the event
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('events.my')->with('success', 'Event deleted successfully!');
    }

    public function interestedPeople($id)
    {
        $event = Event::findOrFail($id);

        // Optional: check if the authenticated user owns the event
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $interestedUsers = $event->interestedUsers;

        return view('events.interested_people', compact('event', 'interestedUsers'));
    }



    public function toggleInterest(Event $event)
    {
        $user = Auth::user();

        if ($event->interestedUsers()->where('user_id', $user->id)->exists()) {
            // Already interested → remove
            $event->interestedUsers()->detach($user->id);
        } else {
            // Not interested → add
            $event->interestedUsers()->attach($user->id);
        }

        return back(); // reload the page
    }

    // Show form to create event
    public function create()
    {
        return view('events.create');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'starts_at' => 'required|date|after:now',
        ]);

        Event::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'starts_at' => $request->starts_at,
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }
}
