@extends('layouts.app')

@section('title','My Events')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-6">
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
                <div class="bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-lg transition duration-300">
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
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 text-lg">You have not created any events yet.</p>
    @endif
</div>
@endsection
