@extends('layouts.app')

@section('title','Create Event')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Create Event</h2>

    <form method="POST" action="{{ route('events.store') }}" class="bg-white shadow-md rounded-xl p-6 space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Title</label>
            <input 
                type="text" 
                name="title" 
                value="{{ old('title') }}" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            @error('title') 
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea 
                name="description" 
                rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >{{ old('description') }}</textarea>
            @error('description') 
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Location --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Location</label>
            <input 
                type="text" 
                name="location" 
                value="{{ old('location') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            @error('location') 
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Start Time --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Start Time</label>
            <input 
                type="datetime-local" 
                name="starts_at" 
                value="{{ old('starts_at') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            @error('starts_at') 
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="text-center">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Create Event
            </button>
        </div>
    </form>
</div>
@endsection
