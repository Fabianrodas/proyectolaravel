<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Conversation | Mango</title>
    <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
        }

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

        .message {
            margin-bottom: 1rem;
        }

        .message.sent {
            text-align: right;
        }

        .message.received {
            text-align: left;
        }

        .message-content {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            background-color: #e9ecef;
            max-width: 75%;
        }

        .message.sent .message-content {
            background-color: #d1e7dd;
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
                        <a class="nav-link mb-3" href="#"><i class="bi bi-chat-left-text me-2"></i> Messages</a>
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
                <h3 class="fw-bold mb-4">Conversation with {{ $conversation->otherUser(auth()->id())->name }}</h3>

                <div class="message-box border rounded shadow-sm mb-3 bg-white">
                    @foreach ($conversation->messages as $message)
                        <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                            <div class="message-content">
                                {{ $message->content }}
                            </div>
                            <div class="text-muted small mt-1">
                                {{ $message->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <form action="{{ route('messages.store') }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <input type="text" name="content" class="form-control" placeholder="Type your message..." required>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Send
                    </button>
                </form>
            </div>

        </div>
    </div>
    <script>
        window.onload = function () {
            var messageBox = document.querySelector('.message-box');
            if (messageBox) {
                messageBox.scrollTop = messageBox.scrollHeight;
            }
        };
    </script>

</body>
</html>