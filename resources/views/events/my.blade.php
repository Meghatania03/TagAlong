@extends('layouts.app')

@section('title','My Events')

@section('content')
<div class="max-w-5xl mx-auto w-full rounded-3xl py-10 px-6";>
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">My Events</h2>

    {{-- Create New Event Button --}}
    <div class="mb-8 text-center">
        <a href="{{ route('events.create') }}">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Create New Event
            </button>
        </a>
    </div>

    {{-- List of user's events --}}
    @if($events->count())
        <div class="grid gap-6">
            @foreach($events as $event)
                <div class="bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-lg transition duration-300"
                style="background: rgba(228, 235, 249, 1);">
                    <div class="flex-1 mb-4 md:mb-0">
                        <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2"><span class="font-medium">Starts at:</span> {{ \Carbon\Carbon::parse($event->starts_at)->format('M d, Y h:i A') }}</p>
                        <p class="text-gray-700">{{ Str::limit($event->description, 150) }}</p>
                    </div>

                    {{-- Delete Button --}}
                    <div class="md:ml-6 flex-shrink-0">
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                Delete
                            </button>
                        </form>
                    </div>

                    {{-- View Interested People Button --}}
                    <div class="md:ml-6 flex-shrink-0">
                        <a href="{{ route('events.interestedPeople', $event->id) }}">
                            <button class="w-full font-semibold py-1.5 px-3 rounded-lg transition duration-200 flex items-center justify-center text-sm bg-indigo-600 text-white hover:bg-indigo-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                View Interested ({{ $event->interestedUsers->count() }})
                            </button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 text-lg">You have not created any events yet.</p>
    @endif
</div>
@endsection
