<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications for the authenticated user.
     */
    public function index(): View
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return back()->with('status', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return back()->with('status', 'All notifications marked as read.');
    }

    /**
     * Get unread notification count for AJAX requests.
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Return latest notifications as JSON for dropdowns (unread first).
     */
    public function feed(Request $request)
    {
        $user = Auth::user();

        // Fetch unread first then read, limit 10 total
        $unread = $user->unreadNotifications()->latest()->take(10)->get();
        $remaining = max(0, 10 - $unread->count());
        $read = $remaining > 0 ? $user->readNotifications()->latest()->take($remaining)->get() : collect();

        $all = $unread->concat($read)->map(function ($n) {
            return [
                'id' => $n->id,
                'type' => class_basename($n->type),
                'data' => $n->data,
                'read_at' => optional($n->read_at)->toIso8601String(),
                'created_at' => $n->created_at->toIso8601String(),
                'created_human' => $n->created_at->diffForHumans(),
            ];
        })->values();

        return response()->json([
            'items' => $all,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }
}
