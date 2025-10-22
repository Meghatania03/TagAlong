<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Users;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Show either chat list or specific chat
    public function index(Request $request, $partnerId = null)
    {
        // prefer route param, fall back to query param if needed
        $partnerId = $partnerId ?? $request->query('user') ?? $request->query('partner');
        if (! $partnerId) {
            return redirect()->route('messages.index');
        }

        $partner = Users::findOrFail($partnerId);
        $authId = Auth::id();

        $messages = Message::where(function ($q) use ($authId, $partnerId) {
            $q->where('sender_id', $authId)->where('receiver_id', $partnerId);
        })->orWhere(function ($q) use ($authId, $partnerId) {
            $q->where('sender_id', $partnerId)->where('receiver_id', $authId);
        })->orderBy('created_at')->get();

        return view('messages.index', [
            'receiverId' => $partner->id,
            'partner'    => $partner,
            'person'     => $partner,   // alias for views that expect $person
            'messages'   => $messages,
        ]);
    }

    // Fetch all messages with a user
    public function fetch($otherUserId)
    {
        $authId  = (int) Auth::id();
        $otherId = (int) $otherUserId;

        $messages = Message::where(function ($q) use ($authId, $otherId) {
            $q->where('sender_id', $authId)->where('receiver_id', $otherId);
        })->orWhere(function ($q) use ($authId, $otherId) {
            $q->where('sender_id', $otherId)->where('receiver_id', $authId);
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    // list messages
    public function list($userId = null)
    {
        $authId = Auth::id();

        // build conversations list (partner, last_message, updated_at)
        $partnerIds = Message::where(function ($q) use ($authId) {
            $q->where('sender_id', $authId)->orWhere('receiver_id', $authId);
        })->get()
          ->map(function ($m) use ($authId) {
              return $m->sender_id === $authId ? $m->receiver_id : $m->sender_id;
          })->unique()->values();

        $conversations = $partnerIds->map(function ($pid) use ($authId) {
            $last = Message::where(function ($q) use ($authId, $pid) {
                $q->where('sender_id', $authId)->where('receiver_id', $pid);
            })->orWhere(function ($q) use ($authId, $pid) {
                $q->where('sender_id', $pid)->where('receiver_id', $authId);
            })->orderByDesc('created_at')->first();

            return (object) [
                'partner' => Users::find($pid),
                'last_message' => $last ? $last->message : '',
                'updated_at' => $last ? $last->created_at : now(),
            ];
        });

        // If no partner specified, show inbox (conversations)
        if (! $userId) {
            return view('messages.list', compact('conversations'));
        }

        // partner specified: load partner and conversation messages
        $partner = Users::findOrFail($userId);

        $messages = Message::where(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authId);
        })->orderBy('created_at')->get();

        return view('messages.list', compact('partner', 'messages', 'conversations'));
    }

    // Send a message
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        event(new MessageSent($message));

        // Always return JSON for AJAX clients (no redirect)
        return response()->json($message, 201);
    }
}
