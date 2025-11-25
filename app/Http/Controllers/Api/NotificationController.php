<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    public function markAsRead($id)
    {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return response([
            'success' => true,
        ]);
    }

    public function markAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
