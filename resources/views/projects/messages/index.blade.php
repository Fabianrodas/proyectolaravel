<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Messages | Mango</title>
    <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .left-side-buttons {
            padding-top: 1.875rem;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .nav-link {
            font-weight: bold;
            font-size: 1rem;
            color: #0d6efd;
        }

        .btn-wide {
            width: 100%;
            height: 3.125rem;
            font-size: 1.25rem;
            border-radius: 1.5625rem;
        }

        .message-box {
            max-height: 60vh;
            overflow-y: auto;
            padding: 1rem;
            background-color: #fff;
        }

        .message-content {
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            max-width: 75%;
        }

        .message.sent {
            justify-content: end;
        }

        .message.received {
            justify-content: start;
        }

        .hover-bg-light:hover {
            background-color: #f8f9fa;
        }

        .message-content.sent-message {
            background-color: #0d6efd;
            color: white;
            margin-bottom: 0.5rem;
        }

        .message-content.sent-message .text-muted {
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 0.75rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 bg-light text-start ps-2">
                <div class="left-side-buttons">
                    <nav class="nav flex-column">
                        <a href="{{ route('profile') }}">
                            <img src="{{ asset(Auth::user()->image ?? 'storage/images/default.jpg') }}"
                                class="rounded-circle mb-5 mx-auto d-block" width="80" height="80">
                        </a>
                        <a class="nav-link mb-3" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>
                            Home</a>
                        <a class="nav-link mb-3" href="{{ route('search') }}"><i class="bi bi-search me-2"></i>
                            Search</a>
                        <a class="nav-link mb-3" href="#"><i class="bi bi-bell me-2"></i> Notifications</a>
                        <a class="nav-link mb-3" href="{{ route('messages.index') }}"><i
                                class="bi bi-chat-left-text me-2"></i> Messages</a>
                        <a class="nav-link mb-5" href="{{ route('about') }}"><i class="bi bi-info-circle me-2"></i>
                            About us</a>
                    </nav>
                    <div class="buttons d-grid gap-3 mt-5">
                        <a href="{{ route('posts.create') }}" class="btn btn-outline-dark btn-wide">Post</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-wide">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-10 p-4">
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Mango Logo" width="70">
                </div>
                <h3 class="fw-bold mb-4">Messages</h3>
                <div class="row border rounded shadow" style="height: 70vh; overflow: hidden;">
                    <div class="col-md-4 border-end overflow-auto">
                        <h5 class="border-bottom p-3 mb-0">Conversations</h5>
                        @forelse ($conversations as $conversation)
                            @php
                                $otherUser = $conversation->user1_id === auth()->id() ? $conversation->user2 : $conversation->user1;
                                $lastMessage = $conversation->messages->last();
                            @endphp
                            <a href="{{ route('messages.index', ['conversation_id' => $conversation->id]) }}"
                                class="text-decoration-none text-dark">
                                <div class="d-flex align-items-center p-3 border-bottom hover-bg-light">
                                    <img src="{{ asset($otherUser->image ?? '/storage/images/default.jpg') }}"
                                        class="rounded-circle me-3" width="50" height="50">
                                    <div>
                                        <strong>{{ $otherUser->name }}</strong><br>
                                        <small
                                            class="text-muted">{{ $lastMessage ? $lastMessage->content : 'No messages yet' }}</small>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-3 text-muted">You have no conversations yet.</div>
                        @endforelse
                    </div>

                    <div class="col-md-8 d-flex flex-column">
                        @if(isset($selectedConversation))
                            @php
                                $otherUser = $selectedConversation->otherUser(auth()->id());
                            @endphp
                            @if($otherUser)
                                <div class="border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center px-3">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('users.profile', $otherUser->id) }}">
                                            <img src="{{ asset($otherUser->image ?? 'storage/images/default.jpg') }}"
                                                class="rounded-circle me-3" width="50" height="50" alt="{{ $otherUser->name }}">
                                        </a>
                                        <h5 class="mb-0 fw-bold">{{ $otherUser->name }}</h5>
                                    </div>
                                    @if(Auth::id() !== $otherUser->id)
                                        <form action="{{ route('follow.toggle', $otherUser->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="btn {{ auth()->user()->isFollowing($otherUser->id) ? 'btn-primary' : 'btn-outline-primary' }}">
                                                {{ auth()->user()->isFollowing($otherUser->id) ? 'Following' : 'Follow' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="message-box flex-grow-1 overflow-auto">
                                    @foreach ($selectedConversation->messages as $message)
                                        <div
                                            class="d-flex message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }} mb-2">
                                            <div
                                                class="message-content {{ $message->sender_id === auth()->id() ? 'sent-message' : 'bg-light' }}">
                                                {{ $message->content }}
                                                <div class="text-muted small">{{ $message->created_at->format('d M Y, H:i') }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <form action="{{ route('messages.store') }}" method="POST"
                                    class="d-flex align-items-center mt-3 gap-2">
                                    @csrf
                                    <input type="hidden" name="conversation_id" value="{{ $selectedConversation->id }}">
                                    <input type="text" name="content" class="form-control" placeholder="Type your message..."
                                        required>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Send</button>
                                </form>
                            @else
                                <div class="text-center text-muted my-auto">User not found</div>
                            @endif
                        @else
                            <div class="text-center text-muted my-auto">Select a conversation to start chatting</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>