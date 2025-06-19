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
            return back()->with('error', 'Unauthorized');
        }
    
        $follower = $notification->sender;
        $authUser = auth()->user();
    
        $authUser->followers()->updateExistingPivot($follower->id, ['status' => 'accepted']);
    
        $notification->delete();
    
        Notification::create([
            'sender_id' => $follower->id,
            'receiver_id' => $authUser->id,
            'type' => 'new_follower',
        ]);
    
        return redirect()->back()->with('success', 'Follow request accepted.');
    }    

    public function decline($id)
    {
        $notification = Notification::findOrFail($id);
    
        if ($notification->receiver_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $notification->delete();
    
        return response()->json(['status' => 'deleted']);
    }
    
}
