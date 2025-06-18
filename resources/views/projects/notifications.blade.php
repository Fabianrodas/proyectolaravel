<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mango - Notifications</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    .btn-wide {
      width: 100%;
      height: 3.125rem;
      font-size: 1.25rem;
      border-radius: 1.5625rem;
    }
    .left-side-buttons {
      padding-top: 1.875rem;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }

    .right-sidebar {
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }

    .buttons {
      display: flex;
      flex-direction: column;
      gap: 1.875rem;
      margin-top: 4.6875rem;
    }

    .btn-post,
    .btn-logout {
      color: black;
      width: 9.375rem;
      height: 3.75rem;
      border-radius: 1.5625rem;
      font-size: 1.25rem;
    }

    .nav-link {
      font-weight: bold;
      font-size: 1rem;
      color: #0d6efd;
    }

    .logo-mango {
      width: 140px;
      display: block;
      margin: 0 auto 10px auto;
    }

    .notifications-title {
      font-size: 1.6rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
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
            <a class="nav-link mb-3" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i> Home</a>
            <a class="nav-link mb-3" href="{{ route('search') }}"><i class="bi bi-search me-2"></i> Search</a>
            <a class="nav-link mb-3" href="{{ route('notifications') }}"><i class="bi bi-bell me-2"></i> Notifications</a>
            <a class="nav-link mb-3" href="{{ route('messages.index') }}">
            <i class="bi bi-chat-left-text me-2"></i> Messages</a>
            <a class="nav-link mb-5" href="{{ route('about') }}"><i class="bi bi-info-circle me-2"></i> About us</a>
          </nav>
          <div class="buttons d-grid gap-3 mt-5">
            <a href="{{ route('posts.create') }}" class="btn btn-outline-dark btn-wide">Post</a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-outline-dark btn-wide">Log Out</button>
            </form>
          </div>
          </nav>
        </div>
      </div>

    <div class="col-10 py-4">
      <div class="text-center">
        <img src="{{ asset('storage/images/logo.png') }}" alt="Mango Logo" class="logo-mango">
        <h3 class="notifications-title">Notifications</h3>
      </div>

      <div class="container mt-4">
        @forelse($notifications as $notification)
          @if($notification->type === 'follow')
            <div class="card mb-3">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  <img src="{{ asset($notification->sender->image ?? 'storage/images/default.jpg') }}" class="rounded-circle me-3" width="50" height="50">
                  <div>
                    <strong>{{ $notification->sender->username }}</strong><br>
                    <span class="text-muted">wants to follow you</span>
                  </div>
                </div>
                <div class="d-flex">
                  <form action="{{ route('notifications.accept', $notification->id) }}" method="POST" class="me-2">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                  </form>
                  <form action="{{ route('notifications.decline', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                  </form>
                </div>
              </div>
            </div>
          @endif
        @empty
          <div class="alert alert-info text-center">You have no new notifications.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>
</body>
</html>
