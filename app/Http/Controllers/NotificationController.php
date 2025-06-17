<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller; 
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('receiver_id', Auth::id())
            ->with('sender')
            ->latest()
            ->get();

        return view('projects.notifications', compact('notifications'));
    }

    public function accept($id)
{
    $notification = Notification::findOrFail($id);

    if ($notification->receiver_id !== auth()->id()) {
        abort(403);
    }

    auth()->user()
        ->followers()
        ->updateExistingPivot($notification->sender_id, ['status' => 'accepted']);

    $notification->delete();

    return back();
}

public function decline($id)
{
    $notification = Notification::findOrFail($id);

    if ($notification->receiver_id !== auth()->id()) {
        abort(403);
    }

    // Elimina relación y la notificación
    auth()->user()->followers()->detach($notification->sender_id);
    $notification->delete();

    return back();
}
}
