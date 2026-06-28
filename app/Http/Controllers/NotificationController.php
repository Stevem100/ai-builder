<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', Auth::id())->latest()->get();
        $unreadCount = $notifications->where('read', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function apiIndex()
    {
        return response()->json(Notification::where('user_id', Auth::id())->latest()->get());
    }

    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        $notification->update(['read' => true]);
        return response()->json(['read' => true]);
    }
}