@extends('layouts.app')
@section('title', 'Chat')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Chat with {{ $partner->name ?? 'User' }}</h2>

    <div id="chat-box" class="h-96 overflow-y-auto border rounded-lg p-4 bg-gray-50 mb-4">
        @if(!empty($messages))
            @foreach($messages as $m)
                <div class="mb-2 {{ $m->sender_id === Auth::id() ? 'text-right' : 'text-left' }}" data-message-id="{{ $m->id }}">
                    <span class="inline-block px-3 py-2 rounded-lg {{ $m->sender_id === Auth::id() ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                        {{ $m->message }}
                    </span>
                </div>
            @endforeach
        @endif
    </div>

    <form id="chat-form" class="flex space-x-2" onsubmit="return false;">
        @csrf
        <input type="hidden" id="receiver_id" value="{{ $receiverId }}">
        <input id="message" name="message" type="text" class="flex-1 border rounded-lg px-4 py-2" placeholder="Type your message..." autocomplete="off" />
        <button type="button" id="send-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Send</button>
    </form>
</div>

<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.min.js"></script>

<script>
console.log('chat script start');

// ensure axios sends cookies for /broadcasting/auth
axios.defaults.withCredentials = true;

// CSRF token
const CSRF_TOKEN = (function() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta && meta.content) return meta.content;
    const input = document.querySelector('input[name="_token"]');
    return input ? input.value : '';
})();
axios.defaults.headers.common['X-CSRF-TOKEN'] = CSRF_TOKEN;

const userId = {{ Auth::id() ?? 'null' }};
const receiverEl = document.getElementById('receiver_id');
const receiverId = receiverEl ? parseInt(receiverEl.value, 10) : null;
const chatBox = document.getElementById('chat-box');

// prevent duplicates: collect server-rendered message ids
const existingMessageIds = new Set(
    Array.from(document.querySelectorAll('[data-message-id]'))
         .map(el => parseInt(el.getAttribute('data-message-id'), 10))
         .filter(Boolean)
);

// append helper
function appendMessage(m) {
    if (!m) return;
    if (m.id && existingMessageIds.has(Number(m.id))) return;
    const cb = chatBox || document.getElementById('chat-box');
    if (!cb) return;
    const div = document.createElement('div');
    div.className = 'mb-2 ' + (m.sender_id === userId ? 'text-right' : 'text-left');
    if (m.id) div.setAttribute('data-message-id', m.id);
    div.innerHTML = `<span class="inline-block px-3 py-2 rounded-lg ${m.sender_id === userId ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800'}">${m.message}</span>`;
    cb.appendChild(div);
    cb.scrollTop = cb.scrollHeight;
    if (m.id) existingMessageIds.add(Number(m.id));
}

// fetch previous messages (safeguarded)
if (receiverId) {
    axios.get(`/messages/fetch/${receiverId}`)
        .then(res => {
            (res.data || []).forEach(appendMessage);
        })
        .catch(err => console.error('Fetch error:', err));
} else {
    console.warn('receiverId missing');
}

// send handler (AJAX, stay on page)
const sendBtn = document.getElementById('send-btn');
sendBtn && sendBtn.addEventListener('click', () => {
    const msgInput = document.getElementById('message');
    const msg = msgInput ? msgInput.value.trim() : '';
    if (!msg) return;

    axios.post('/messages/send', {
        receiver_id: receiverId,
        message: msg
    })
    .then(res => {
        appendMessage(res.data);
        if (msgInput) { msgInput.value = ''; msgInput.focus(); }
    })
    .catch(err => {
        console.error('Send error:', err);
        if (err.response && err.response.status === 422 && err.response.data.errors) {
            alert(Object.values(err.response.data.errors).flat().join("\n"));
        }
    });
});

// init Echo (optional; ensure routes/channels.php has Broadcast::routes())
(function initEcho() {
    const EchoCandidate = window.EchoLib || window.Echo;
    if (!EchoCandidate) return console.warn('Echo IIFE not found');
    try {
        const echoOptions = {
            broadcaster: 'pusher',
            key: '{{ env("PUSHER_APP_KEY") ?? "" }}',
            cluster: '{{ env("PUSHER_APP_CLUSTER") ?? "" }}',
            forceTLS: true,
            auth: { headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'X-Requested-With': 'XMLHttpRequest' } }
        };
        if (typeof EchoCandidate === 'function') {
            window.Echo = new EchoCandidate(echoOptions);
        } else if (EchoCandidate && EchoCandidate.constructor && typeof EchoCandidate.constructor === 'function' && EchoCandidate.constructor !== Object) {
            window.Echo = new EchoCandidate.constructor(echoOptions);
        } else if (EchoCandidate && typeof EchoCandidate.init === 'function') {
            EchoCandidate.init(echoOptions);
            window.Echo = EchoCandidate;
        } else if (typeof EchoCandidate === 'object') {
            window.Echo = EchoCandidate;
        }
    } catch (e) {
        console.error('Echo init failed', e);
    }

    if (window.Echo && userId) {
        window.Echo.private('chat.' + userId)
            .listen('MessageSent', (e) => {
                const payload = e.message || e;
                if (payload.sender_id !== userId) appendMessage(payload);
            });
    }
})();
</script>
@endsection
