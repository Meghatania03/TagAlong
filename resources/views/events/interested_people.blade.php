@extends('layouts.app')

@section('title', 'Interested People')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Interested People for "{{ $event->title }}"</h1>
            <p class="text-gray-600 mb-6">{{ $event->description }}</p>

            @if($people->count())
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($people as $user)
                <div class="bg-gray-50 rounded-xl p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
                    <div class="flex items-center space-x-4 mb-4">
                        {{-- Profile Picture --}}
                        <div class="flex-shrink-0">
                            @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500">
                            @else
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center text-xl font-bold text-gray-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            @endif
                        </div>

                        {{-- User Info --}}
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                            @if($user->location)
                            <p class="text-gray-500 text-sm">{{ $user->location }}</p>
                            @endif
                            @if($user->gender)
                            <p class="text-gray-500 text-sm">Gender: {{ $user->gender }}</p>
                            @endif
                            @if($user->age)
                            <p class="text-gray-500 text-sm">Age: {{ $user->age }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex space-x-2 mt-auto">
                        <a href="{{ route('users.show_profile', $user->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                            View Profile
                        </a>

                        <a href="{{ route('messages.chat', ['partner' => $user->id]) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg">
                            Message
                        </a>

                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 text-lg">No one has shown interest in this event yet.</p>
            @endif
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mt-8 text-center">
        <a href="{{ route('events.my') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
            Back to My Events
        </a>
    </div>
</div>
@endsection
