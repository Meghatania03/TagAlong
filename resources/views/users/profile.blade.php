@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-8 p-8">
            {{-- Profile Picture --}}
            <div class="flex-shrink-0 mb-6 md:mb-0">
                @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-40 h-40 rounded-full object-cover border-4 border-indigo-500 shadow-md">
                @else
                <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center text-3xl font-bold text-gray-500 border-4 border-indigo-500">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                @endif
            </div>

            {{-- Profile Info --}}
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $user->name }}</h1>
                <p class="text-gray-600 mb-2">
                    <span class="font-medium">Gender:</span> {{ ucfirst($user->gender) }}
                    • <span class="font-medium">Age:</span> {{ $user->age }}
                </p>
                <p class="text-gray-600 mb-2">
                    <span class="font-medium">Location:</span> {{ $user->location }}
                </p>

                @if($user->phone)
                <p class="text-gray-600 mb-2">
                    <span class="font-medium">Phone:</span> {{ $user->phone }}
                </p>
                @endif

                @if($user->bio)
                <p class="text-gray-700 mt-4 leading-relaxed">{{ $user->bio }}</p>
                @endif

                {{-- Social Links --}}
                @if($user->social_links)
                @php
                $links = json_decode($user->social_links, true);
                @endphp
                <div class="mt-4 flex flex-wrap gap-3 justify-center md:justify-start">
                    @foreach($links as $platform => $url)
                    <a href="{{ $url }}" target="_blank" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold hover:bg-indigo-200 transition">
                        {{ ucfirst($platform) }}
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- Interests --}}
                @if($user->interests)
                @php
                $interests = json_decode($user->interests, true);
                @endphp
                <div class="mt-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Interests</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($interests as $interest)
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-gray-700 text-sm">
                            {{ $interest }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- User's Created Events --}}
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Created Events</h2>

        @if($user->events->count())
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($user->events as $event)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-300 flex flex-col"
            style="background: rgba(228, 235, 249, 1);">
                <h3 class="text-xl font-bold text-indigo-600 mb-2">{{ $event->title }}</h3>
                <p class="text-gray-600 mb-2"><span class="font-medium">Location:</span> {{ $event->location }}</p>
                <p class="text-gray-600 mb-2"><span class="font-medium">Time:</span> {{ $event->starts_at }}</p>
                <p class="text-gray-700 mb-4">{{ Str::limit($event->description, 120) }}</p>

                {{-- Interested Button --}}
                @if(auth()->check())
                @php
                $isInterested = $event->interestedUsers->contains(auth()->id());
                @endphp
                <form method="POST" action="{{ route('events.toggleInterest', $event->id) }}">
                    @csrf
                    <button type="submit" class="w-full font-semibold py-1.5 px-3 rounded-lg transition duration-200 flex items-center justify-center text-sm
                                       {{ $isInterested ? 'bg-gray-400 text-white hover:bg-gray-500' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a6.979 6.979 0 00-4.926 2.07 6.972 6.972 0 00-2.072 4.927c0 4.418 7 10.504 7 10.504s7-6.086 7-10.504a6.972 6.972 0 00-2.072-4.927A6.979 6.979 0 0011.48 3.5z" />
                        </svg>
                        Interested ({{ $event->interestedUsers->count() }})
                    </button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center">No events created yet.</p>
        @endif
    </div>

</div>
@endsection
