<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2', 'messages.sender'])
            ->get();

        $selectedConversation = null;
        if ($request->has('conversation_id')) {
            $selectedConversation = $conversations->where('id', $request->conversation_id)->first();
            if ($selectedConversation) {
                $selectedConversation->messages()
                    ->where('sender_id', '!=', $user->id)
                    ->where('read', false)
                    ->update(['read' => true]);
            }
        }

        return view('projects.messages.index', compact('conversations', 'selectedConversation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'conversation_id' => 'required|exists:conversations,id',
        'content' => 'required|string|max:1000',
    ]);

    $conversation = Conversation::findOrFail($request->conversation_id);
    $authUser = auth()->user();
    $targetUser = $conversation->otherUser($authUser->id);

    $isFollowingAccepted = $authUser->followings()
        ->where('followed_id', $targetUser->id)
        ->get()
        ->pluck('pivot.status')
        ->contains('accepted');

    if ($targetUser->is_private && !$isFollowingAccepted) {
        return redirect()->back()->with('error', 'You cannot message this user unless they approve your follow request.');
    }

    $message = Message::create([
        'conversation_id' => $request->conversation_id,
        'sender_id' => $authUser->id,
        'content' => $request->content,
    ]);

    Notification::create([
        'sender_id' => $authUser->id,
        'receiver_id' => $targetUser->id,
        'type' => 'message',
    ]);
    

    return redirect()->route('messages.index', ['conversation_id' => $conversation->id]);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }

    public function start($userId)
    {
        $authUser = auth()->user();

        if ($authUser->id == $userId) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        $targetUser = User::findOrFail($userId);

        if ($targetUser->is_private && !$targetUser->isFollowedBy($authUser->id)) {
            return redirect()->back()->with('error', 'You cannot message this user. Their account is private.');
        }

        $conversation = Conversation::where(function ($q) use ($authUser, $userId) {
            $q->where('user1_id', $authUser->id)->where('user2_id', $userId);
        })->orWhere(function ($q) use ($authUser, $userId) {
            $q->where('user1_id', $userId)->where('user2_id', $authUser->id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => $authUser->id,
                'user2_id' => $userId,
            ]);
        }

        return redirect()->route('messages.index', ['conversation_id' => $conversation->id]);
    }
    public function fetchNewMessages($conversationId, $lastId)
    {
        $conversation = Conversation::findOrFail($conversationId);

        if (!$conversation->participants()->contains(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $conversation->messages()
            ->where('id', '>', $lastId)
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }
    public function unreadCounts()
    {
        $user = auth()->user();

        $conversations = Conversation::where(function ($query) use ($user) {
            $query->where('user1_id', $user->id)
                ->orWhere('user2_id', $user->id);
        })
        ->with(['messages' => function ($query) {
            $query->latest('created_at');
        }])
        ->get();

        $data = [];

        foreach ($conversations as $conversation) {
            $messages = $conversation->messages;

            $unread = $messages->where('sender_id', '!=', $user->id)
                            ->where('read', false);

            $lastMessage = $messages->first(); // más reciente
            $preview = $lastMessage ? $lastMessage->content : null;

            $data[$conversation->id] = [
                'count' => $unread->count(),
                'preview' => $preview,
            ];
        }

        return response()->json($data);
    }

    public function markAsRead($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);

        if (!$conversation->participants()->contains(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $conversation->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json(['status' => 'ok']);
    }

}
