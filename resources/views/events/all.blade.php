@extends('layouts.app')

@section('title', 'All Events')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center px-4"
     style="background: rgba(157, 175, 255, 1);">

    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-lg">All Events</h1>
        <p class="mt-4 text-lg md:text-xl text-indigo-100 drop-shadow-sm">
            Discover exciting activities happening around you!
        </p>
    </div>

    {{-- Events Grid --}}
     <div class="max-w-7xl w-full rounded-3xl shadow-2xl p-10 transform transition duration-500 hover:scale-[1.01]"
         style="background: rgba(182, 195, 254, 1);">
        @if($events->count() > 0)
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($events as $event)
            <div class="rounded-2xl shadow-md hover:shadow-2xl hover:scale-105 transition duration-300 overflow-hidden flex flex-col border border-gray-100"
                 style="background: rgba(228, 235, 249, 1);">

                {{-- Event Content --}}
                <div class="p-5 flex flex-col flex-grow">
                    {{-- Title --}}
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->title }}</h3>

                    {{-- Creator Info --}}
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        @if($event->user && $event->user->profile_picture)
                        <img src="{{ asset('storage/' . $event->user->profile_picture) }}" 
                             class="w-8 h-8 rounded-full object-cover mr-2 border border-gray-200">
                        @endif
                        <span>
                            By
                            @if($event->user)
                            <a href="{{ route('users.show_profile', $event->user_id) }}" 
                               class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                {{ $event->user->name }}
                            </a>
                            @else
                            <span class="italic">Unknown</span>
                            @endif
                        </span>
                    </div>

                    {{-- Description --}}
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $event->description }}</p>

                    {{-- Details --}}
                    <div class="text-gray-700 text-sm mb-4 space-y-1">
                        <p><span class="font-semibold">📍 Location:</span> {{ $event->location ?? 'Not specified' }}</p>
                        <p><span class="font-semibold">🕒 Time:</span> {{ \Carbon\Carbon::parse($event->starts_at)->format('M d, Y h:i A') }}</p>
                    </div>

                    {{-- Interested Button --}}
                    <form method="POST" action="{{ route('events.toggleInterest', $event->id) }}" class="mt-auto">
                        @csrf
                        @php
                            $isInterested = $event->interestedUsers->contains(auth()->id());
                        @endphp
                        <button type="submit" 
                            class="w-full font-semibold py-2 rounded-xl flex items-center justify-center transition duration-300 text-sm shadow-md
                            {{ $isInterested ? 'bg-gray-400 text-white hover:bg-gray-500' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M11.48 3.499a6.979 6.979 0 00-4.926 2.07 6.972 6.972 0 00-2.072 4.927c0 4.418 7 10.504 7 10.504s7-6.086 7-10.504a6.972 6.972 0 00-2.072-4.927A6.979 6.979 0 0011.48 3.5z" />
                            </svg>
                            Interested ({{ $event->interestedUsers->count() }})
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-600 text-lg mt-10">No events available at the moment.</p>
        @endif
    </div>
</div>
@endsection
