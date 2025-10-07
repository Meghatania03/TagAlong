<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TagAlong</title>

    {{-- Load compiled CSS from Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">

<div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex flex-col justify-center items-center px-4">

    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-6xl font-extrabold text-white drop-shadow-lg">TagAlong</h1>
        <p class="mt-4 text-xl md:text-2xl text-indigo-100 drop-shadow-sm">
            Join now to find buddies for activities!
        </p>
    </div>

    {{-- Signup Card --}}
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl p-10 transform transition duration-500 hover:scale-105">
        
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Create Your Account</h2>
        <p class="text-gray-500 text-center mb-6">Sign up to start finding activity partners</p>

        {{-- Signup Form --}}
        <form method="POST" action="{{ route('signup.submit') }}" class="space-y-5" enctype="multipart/form-data">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input id="name" name="name" type="text" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Gender --}}
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" name="gender"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            {{-- Age --}}
            <div>
                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                <input id="age" name="age" type="number" min="18" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input id="phone" name="phone" type="text"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Bio --}}
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea id="bio" name="bio" rows="3"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3"></textarea>
            </div>

            {{-- Profile Picture --}}
            <div>
                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <input id="profile_picture" name="profile_picture" type="file" accept="image/*"
                    class="mt-1 block w-full text-gray-700">
            </div>

            {{-- Location --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input id="location" name="location" type="text" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Interests --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Interests (choose up to 3)</label>
                <div class="grid grid-cols-2 gap-2">
                    @php
                        $interests = ['Music', 'Sports', 'Travel', 'Reading', 'Gaming', 'Cooking', 'Movies', 'Art'];
                    @endphp
                    @foreach($interests as $interest)
                    <label class="inline-flex items-center mt-1">
                        <input type="checkbox" name="interests[]" value="{{ strtolower($interest) }}" 
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 interest-checkbox">
                        <span class="ml-2 text-gray-700">{{ $interest }}</span>
                    </label>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mt-1">You can select up to 3 interests.</p>
            </div>

            {{-- Social Links --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Social Links (optional)</label>
                <input type="url" name="social_links[facebook]" placeholder="Facebook URL"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                <input type="url" name="social_links[twitter]" placeholder="Twitter URL"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                <input type="url" name="social_links[instagram]" placeholder="Instagram URL"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold rounded-xl py-3 hover:bg-indigo-700 transition duration-300 shadow-md hover:shadow-lg">
                    Sign Up
                </button>
            </div>
        </form>

        {{-- Login Link --}}
        <p class="mt-6 text-center text-gray-600">
            Already have an account?
            <a href="" class="text-indigo-600 hover:underline font-semibold">Login</a>
        </p>
    </div>
</div>

{{-- Script to limit interests selection to 3 --}}
<script>
    const maxSelection = 3;
    const checkboxes = document.querySelectorAll('.interest-checkbox');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const checkedCount = document.querySelectorAll('.interest-checkbox:checked').length;
            if (checkedCount >= maxSelection) {
                checkboxes.forEach(box => {
                    if (!box.checked) box.disabled = true;
                });
            } else {
                checkboxes.forEach(box => box.disabled = false);
            }
        });
    });
</script>

</body>
</html>
