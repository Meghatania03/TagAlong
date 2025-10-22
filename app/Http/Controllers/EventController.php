<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    // All events (main feed)
    public function index(Request $request)
    {
        $query = Event::withCount('interestedUsers')->with('user');

        // Apply filters
        if ($request->filled('gender')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('age_min')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('age', '>=', $request->age_min);
            });
        }

        if ($request->filled('age_max')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('age', '<=', $request->age_max);
            });
        }

        $events = $query->latest()->get();
        return view('events.all', compact('events'));
    }

    // Show filter form
    public function filter()
    {
        return view('events.filter');
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
        // load the event and its interested users (assumes Event::interestedUsers relationship exists)
        $event = Event::with('interestedUsers')->findOrFail($id);

        // map to a collection of Users
        $people = $event->interestedUsers;


        // pass $people to the view (and event if the view needs it)
        return view('events.interested_people', compact('event','people'));
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
