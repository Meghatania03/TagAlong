<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TagAlong</title>

    {{-- Load compiled CSS from Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">

<div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex flex-col justify-center items-center px-4">

    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-6xl font-extrabold text-white drop-shadow-lg">TagAlong</h1>
        <p class="mt-4 text-xl md:text-2xl text-indigo-100 drop-shadow-sm">
            Find buddies to do everyday activities together!
        </p>
    </div>

    {{-- Login Card --}}
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 transform transition duration-500 hover:scale-105">
        
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Welcome Back!</h2>
        <p class="text-gray-500 text-center mb-6">Log in to start finding your activity buddies</p>

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" required autofocus
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
            </div>

            {{-- Forgot password --}}
            <div class="text-right">
                <a href="" class="text-sm text-indigo-600 hover:underline font-medium">Forgot password?</a>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold rounded-xl py-3 hover:bg-indigo-700 transition duration-300 shadow-md hover:shadow-lg">
                    Login
                </button>
            </div>
        </form>

        {{-- Signup Link --}}
        <p class="mt-6 text-center text-gray-600">
            Don’t have an account?
            <a href="{{ route('signup') }}" class="text-indigo-600 hover:underline font-semibold">Sign Up</a>
        </p>
    </div>
</div>

</body>
</html>
