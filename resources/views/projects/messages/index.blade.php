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
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">

      {{-- Left menu --}}
      <div class="col-2 bg-light text-start ps-2">
        <div class="left-side-buttons">
          <nav class="nav flex-column">
            <a href="{{ route('profile') }}">
              <img src="{{ asset(Auth::user()->image ?? 'storage/images/default.jpg') }}"
                   class="rounded-circle mb-5 mx-auto d-block" width="80" height="80">
            </a>
            <a class="nav-link mb-3" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i> Home</a>
            <a class="nav-link mb-3" href="{{ route('search') }}"><i class="bi bi-search me-2"></i> Search</a>
            <a class="nav-link mb-3" href="#"><i class="bi bi-bell me-2"></i> Notifications</a>
            <a class="nav-link mb-3" href="#"><i class="bi bi-chat-left-text me-2"></i> Messages</a>
            <a class="nav-link mb-5" href="{{ route('about') }}"><i class="bi bi-info-circle me-2"></i> About us</a>
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
        <h3 class="fw-bold mb-4">Messages</h3>
        <div class="row border rounded shadow" style="height: 70vh; overflow: hidden;">
          <div class="col-md-4 border-end overflow-auto">
            <h5 class="border-bottom p-3 mb-0">Conversations</h5>
            @forelse ($conversations as $conversation)
              @php
                  $otherUser = $conversation->user1_id === auth()->id() ? $conversation->user2 : $conversation->user1;
              @endphp
              <a href="{{ route('messages.show', $conversation->id) }}"
                 class="text-decoration-none text-dark">
                <div class="d-flex align-items-center p-3 border-bottom hover-bg-light">
                  <img src="{{ $otherUser->image ?? '/default.jpg' }}"
                       class="rounded-circle me-3" width="50" height="50">
                  <div>
                    <strong>{{ $otherUser->name }}</strong><br>
                    <small class="text-muted">
                    {{ optional($conversation->messages->last())->content ?? 'No messages yet' }}
                    </small>
                  </div>
                </div>
              </a>
            @empty
              <div class="p-3 text-muted">You have no conversations yet.</div>
            @endforelse
          </div>

          <div class="col-md-8 d-flex justify-content-center align-items-center bg-light">
            <p class="text-muted">Select a conversation to start chatting</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
