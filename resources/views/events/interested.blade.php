@extends('layouts.app')

@section('title','Interested Events')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-6">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Events You're Interested In</h2>

        @if($events->count() > 0)
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($events as $event)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden flex flex-col">
                <div class="p-4 flex flex-col flex-grow">
                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $event->title }}</h3>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                        {{ $event->description }}
                    </p>

                    <!-- Location and Time -->
                    <div class="text-gray-700 text-sm mb-3">
                        <p><span class="font-semibold">Location:</span> {{ $event->location ?? 'Not specified' }}</p>
                        <p><span class="font-semibold">Time:</span> {{ \Carbon\Carbon::parse($event->starts_at)->format('M d, Y h:i A') }}</p>
                    </div>

                    <!-- Interested Button (optional to allow unmarking) -->
                    <form method="POST" action="{{ route('events.toggleInterest', $event->id) }}">
                        @csrf
                        @php
                        $isInterested = $event->interestedUsers->contains(auth()->id());
                        @endphp
                        <button type="submit" class="w-full font-semibold py-1.5 px-3 rounded-lg transition duration-200 flex items-center justify-center text-sm
                                    {{ $isInterested ? 'bg-gray-400 text-white hover:bg-gray-500' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a6.979 6.979 0 00-4.926 2.07 6.972 6.972 0 00-2.072 4.927c0 4.418 7 10.504 7 10.504s7-6.086 7-10.504a6.972 6.972 0 00-2.072-4.927A6.979 6.979 0 0011.48 3.5z" />
                            </svg>
                            Interested ({{ $event->interestedUsers->count() }})
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 text-lg">You haven’t marked interest in any events yet.</p>
        @endif
    </div>
</div>
@endsection
