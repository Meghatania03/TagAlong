<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','TagAlong')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen" style="background: rgba(157, 175, 255, 1);">

  {{-- Header --}}
  <header class="w-full py-4 shadow-md bg-white/70 backdrop-blur-md border-b border-gray-300">
    <nav class="flex items-center gap-6 max-w-7xl mx-auto">
      <a href="{{ route('events.index') }}" class="text-gray-800 hover:text-indigo-700 font-semibold transition">All Events</a>
      <a href="{{ route('events.my') }}" class="text-gray-800 hover:text-indigo-700 font-semibold transition">My Events</a>
      <a href="{{ route('events.interested') }}" class="text-gray-800 hover:text-indigo-700 font-semibold transition">Interested</a>
      <a href="{{ route('messages.index') }}" class="text-gray-800 hover:text-indigo-700 font-semibold transition">Messages</a>
      <a href="{{ route('users.edit', Auth::id()) }}" class="text-gray-800 hover:text-indigo-700 font-semibold transition">
            Profile
          </a>
      <div class="ml-auto flex items-center gap-3">
        @if(Auth::check())
          <span class="text-gray-800 font-medium">Hi, {{ Auth::user()->name }}</span>
          
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-3 py-1 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition font-medium">
              Logout
            </button>
          </form>
        @endif
      </div>
    </nav>
  </header>

  {{-- Flash Messages --}}
  @if(session('success'))
    <div class="max-w-7xl mx-auto mt-6 p-4 rounded-lg bg-green-50/90 border border-green-300 backdrop-blur-sm text-green-800">
      {{ session('success') }}
    </div>
  @endif

  {{-- Main Content --}}
  <main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-7xl">
      @yield('content')
    </div>
  </main>

</body>
</html>
