<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPresenceController extends Controller
{
    public function online(User $user)
    {
        $user->update(['is_online' => true, 'last_seen_at' => now()]);
        return response()->json(['status' => 'ok']);
    }

    public function offline(User $user)
    {
        $user->update(['is_online' => false, 'last_seen_at' => now()]);
        return response()->json(['status' => 'ok']);
    }
}
