<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Mango - Search</title>
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

    .search-box,
    .user-card {
      max-width: 700px;
      margin: 0 auto 25px auto;
    }

    .user-card .btn {
      min-width: 90px;
      font-size: 1rem;
    }

    .logo-mango {
      width: 140px;
    }

    .search-input {
      font-size: 1.2rem;
      height: 50px;
    }

    .search-btn {
      font-size: 1.2rem;
      height: 50px;
    }

    .this-you-badge {
      font-size: 1rem;
      padding: 0.5rem 1.2rem;
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
          </nav>
        </div>
      </div>

      <div class="col-10 py-4">

        <div class="d-flex justify-content-center mb-4" style="height: auto;">
          <a href="/home">
            <img src="/storage/images/logo.png" width="120" height="120">
          </a>
        </div>

        <div class="search-box mb-4">
          <form method="GET" action="{{ route('search') }}" class="d-flex justify-content-center">
            <input type="text" name="search" class="form-control me-2 search-input" placeholder="Search users..."
              value="{{ old('search', $query ?? '') }}">
            <button type="submit" class="btn btn-primary search-btn">Search</button>
          </form>
        </div>
        @if(count($users) > 0)
        @foreach ($users as $user)
        <div class="user-card card">
        <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <a href="{{ route('users.profile', $user->id) }}">
          <img src="{{ asset($user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-3"
          width="65" height="65">
          </a>
          <div>
          <h4 class="mb-0">{{ $user->username }}</h4>
          <small class="fs-6">{{ $user->name }}</small><br>
          <small class="text-muted">{{ $user->followers()->count() }} followers</small>
          </div>
        </div>
        <div class="text-end">
          @if(Auth::id() !== $user->id)
        <form action="{{ route('follow.toggle', $user->id) }}" method="POST" class="d-inline">
        @csrf
        <button
        class="btn {{ auth()->user()->isFollowing($user->id) ? 'btn-primary' : 'btn-outline-primary' }}">
        {{ auth()->user()->isFollowing($user->id) ? 'Following' : 'Follow' }}
        </button>
        </form>
        <a href="{{ route('messages.start', $user->id) }}" class="btn btn-outline-secondary ms-2">
        <i class="bi bi-chat-left-text"></i>
        </a>
        @else
        <span class="badge bg-secondary this-you-badge">
        This is you <i class="bi bi-person-fill ms-1"></i>
        </span>
        @endif
        </div>
        </div>
        </div>
      @endforeach
    @elseif(!empty($query))
      <div class="alert alert-info text-center">
        No users found for "{{ $query }}"
      </div>
    @endif

      </div>
    </div>
  </div>

</body>

</html>