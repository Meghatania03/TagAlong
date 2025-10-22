@extends('layouts.app')

@section('title', 'Filter Events')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center px-4"
     style="background: rgba(157, 175, 255, 1);">

    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-lg">Filter Events</h1>
        <p class="mt-4 text-lg md:text-xl text-indigo-100 drop-shadow-sm">
            Customize your event search!
        </p>
    </div>

    {{-- Filter Form --}}
    <div class="max-w-2xl w-full rounded-3xl shadow-2xl p-10 transform transition duration-500 hover:scale-[1.01]"
         style="background: rgba(238, 241, 255, 1);">
        <form method="GET" action="{{ route('events.index') }}" class="space-y-6">
            @csrf

            {{-- Gender Filter --}}
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                <select name="gender" id="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Genders</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            {{-- Location Filter --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                <input type="text" name="location" id="location" value="{{ request('location') }}" placeholder="Enter location"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Age Range Slider --}}
            <div>
                <label for="age_min" class="block text-sm font-medium text-gray-700 mb-2">Age Range</label>
                <div class="flex items-center space-x-4">
                    <input type="range" name="age_min" id="age_min" min="18" max="100" value="{{ request('age_min', 18) }}"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                    <span id="age_min_value" class="text-sm font-medium text-gray-700">{{ request('age_min', 18) }}</span>
                </div>
                <div class="flex items-center space-x-4 mt-2">
                    <input type="range" name="age_max" id="age_max" min="18" max="100" value="{{ request('age_max', 100) }}"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                    <span id="age_max_value" class="text-sm font-medium text-gray-700">{{ request('age_max', 100) }}</span>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="text-center">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                    Save Filters
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Update slider values dynamically
    document.getElementById('age_min').addEventListener('input', function() {
        document.getElementById('age_min_value').textContent = this.value;
    });
    document.getElementById('age_max').addEventListener('input', function() {
        document.getElementById('age_max_value').textContent = this.value;
    });
</script>

<style>
    .slider::-webkit-slider-thumb {
        appearance: none;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
    }
    .slider::-moz-range-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
        border: none;
    }
</style>
@endsection
