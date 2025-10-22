<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(); // registers POST /broadcasting/auth

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
