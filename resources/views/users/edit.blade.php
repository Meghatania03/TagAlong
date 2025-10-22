@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Edit Profile</h1>

            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Age --}}
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                    <input id="age" name="age" type="number" required min="18" value="{{ old('age', $user->age) }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                    @error('age')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bio --}}
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea id="bio" name="bio" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Profile Picture --}}
                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                    <input id="profile_picture" name="profile_picture" type="file" accept="image/*"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                    @if($user->profile_picture)
                        <p class="mt-2 text-sm text-gray-600">Current: <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current profile picture" class="w-16 h-16 rounded-full inline-block"></p>
                    @endif
                    @error('profile_picture')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input id="location" name="location" type="text" required value="{{ old('location', $user->location) }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Interests --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Interests (Select up to 3)</label>
                    @php
                        $selectedInterests = old('interests', json_decode($user->interests, true) ?? []);
                    @endphp
                    <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach(['Sports', 'Music', 'Art', 'Technology', 'Travel', 'Food', 'Books', 'Movies', 'Gaming', 'Fitness'] as $interest)
                        <label class="flex items-center">
                            <input type="checkbox" name="interests[]" value="{{ $interest }}" {{ in_array($interest, $selectedInterests) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">{{ $interest }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('interests')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Social Links --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Social Links</label>
                    @php
                        $socialLinks = old('social_links', json_decode($user->social_links, true) ?? []);
                    @endphp
                    <div class="space-y-3">
                        @foreach(['facebook' => 'Facebook', 'twitter' => 'Twitter', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn'] as $key => $label)
                        <div>
                            <label for="{{ $key }}" class="block text-sm text-gray-600">{{ $label }}</label>
                            <input id="{{ $key }}" name="social_links[{{ $key }}]" type="url" value="{{ $socialLinks[$key] ?? '' }}"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                        </div>
                        @endforeach
                    </div>
                    @error('social_links')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition duration-300 shadow-md hover:shadow-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
