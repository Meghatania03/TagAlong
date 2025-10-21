<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Tagalong')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
  <header style="padding:12px;border-bottom:1px solid #ddd;">
    <nav style="display:flex;gap:12px;align-items:center;">
      <a href="{{ route('events.index') }}">All Events</a>
      <a href="{{ route('events.my') }}">My Events</a>
      <a href="{{ route('events.interested') }}">Interested</a>
      <a href="{{ route('messages.index') }}">Messages</a>

      <div style="margin-left:auto;">
        @if(Auth::check())
          <span style="margin-right:8px;">Hi, {{ Auth::user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
          </form>
        @endif
      </div>
    </nav>
  </header>

  <main style="padding:20px;">
    @if(session('success'))
      <div style="background:#e6ffed;padding:10px;border:1px solid #b6f0c6;margin-bottom:12px;">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>
</body>
</html>
