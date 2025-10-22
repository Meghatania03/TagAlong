@extends('layouts.app')
@section('title', 'Messages')

@section('content')
<div class="min-h-screen flex flex-col items-center px-4 py-12"
     style="background: rgba(157, 175, 255, 1);">

    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-lg">Your Conversations</h1>
        <p class="mt-4 text-lg md:text-xl text-indigo-100 drop-shadow-sm">
            Chat with people you’ve interacted with
        </p>
    </div>

    {{-- Conversations List --}}
    <div class="max-w-3xl w-full rounded-3xl shadow-2xl p-6"
         style="background: rgba(182, 195, 254, 1);">
        @if($conversations->isEmpty())
            <p class="text-center text-gray-600 text-lg mt-10">No conversations yet.</p>
        @else
            <div class="flex flex-col divide-y">
                @foreach($conversations as $chat)
                <a href="{{ route('messages.chat', ['partner' => $chat->partner->id]) }}" 
                   class="flex items-center justify-between py-4 px-4 rounded-lg transition"
                   style="background: rgba(214, 228, 254, 1); margin-bottom: 8px;">
                   <div class="flex items-center space-x-3">
                       @if($chat->partner && $chat->partner->profile_picture)
                       <img src="{{ asset('storage/' . $chat->partner->profile_picture) }}" 
                            class="w-12 h-12 rounded-full object-cover border border-gray-200">
                       @else
                       <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-lg font-bold text-gray-600">
                           {{ strtoupper(substr($chat->partner->name, 0, 1)) }}
                       </div>
                       @endif
                       <div>
                           <h3 class="text-lg font-semibold text-gray-800">{{ $chat->partner->name }}</h3>
                           <p class="text-sm text-gray-500 truncate w-64">{{ $chat->last_message }}</p>
                       </div>
                   </div>
                   <span class="text-xs text-gray-400">{{ $chat->updated_at->diffForHumans() }}</span>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
<script>
document.querySelectorAll('.chat-link').forEach(a => {
  a.addEventListener('click', function (e) {
    console.log('chat link clicked, href=', this.href);
    // If another script prevented navigation, force it after a tiny delay
    setTimeout(() => {
      if (window.location.href === window.location.href) {
        window.location.href = this.href;
      }
    }, 20);
  });
});
</script>
@endsection
