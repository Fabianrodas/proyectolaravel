<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile | Mango</title>
  <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    html {
      font-size: 16px;
    }

    body {
      background-color: #f5f5f5;
    }

    .left-side-buttons {
      padding-top: 1.875rem; /* 30px */
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }

    .buttons {
      display: flex;
      flex-direction: column;
      gap: 1.875rem; /* 30px */
      margin-top: 4.6875rem; /* 75px */
    }

    .btn-post, .btn-logout {
      color: black;
      width: 9.375rem;   /* 150px */
      height: 3.75rem;   /* 60px */
      border-radius: 1.5625rem; /* 25px */
      font-size: 1.25rem; /* 20px */
    }

    .nav-link {
      font-weight: bold;
      font-size: 1rem;
      color: #0d6efd;
    }

    .tab-btn {
      flex: 1;
      padding: 0.5rem 0;
      border: 1px solid #ccc;
      background-color: white;
      color: #0d6efd;
      font-weight: 600;
    }

    .tab-btn.active {
      background-color: #0d6efd;
      color: white;
      border-color: #0d6efd;
    }
    .row-cols-3 > .col {
      padding: 0.25rem;
    }
    .content-box {
      border: 1px solid #ccc;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      min-height: calc(100vh - 18.75rem); /* 300px */
      margin-top: 1rem;
    }

    .profile-img {
      width: 5.625rem;  /* 90px */
      height: 5.625rem;
      object-fit: cover;
      border-radius: 50%;
    }

    .tabs {
      margin-top: 2rem;
      display: flex;
      gap: 0.0625rem;
    }

    .btn-wide {
    width: 100%;
    height: 3.125rem; /* 50px */
    font-size: 1.25rem; /* 20px */
    border-radius: 1.5625rem; /* 25px */
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-2 bg-light text-start ps-2">
      <div class="left-side-buttons">
        <nav class="nav flex-column">
          <a href="{{ route('profile') }}">
            <img src="{{ asset(Auth::user()->image ?? 'storage/images/default.jpg') }}" class="rounded-circle mb-5 mx-auto d-block" width="80" height="80">
          </a>
          <a class="nav-link mb-3 mt-3" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i> Home</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-search me-2"></i> Search</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-bell me-2"></i> Notifications</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-chat-left-text me-2"></i> Messages</a>
          <a class="nav-link mb-5" href="{{ route('about') }}"><i class="bi bi-info-circle me-2"></i> About us</a>
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

    <!-- Main Content -->
    <div class="col-10 p-4">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center">
          <img src="{{ asset($user->image ?? 'storage/images/default.jpg') }}" class="profile-img me-3" alt="Profile Picture">
          <div>
            <div class="d-flex align-items-center">
              <h5 class="mb-0 fw-bold me-3">{{ '@' . $user->username }}</h5>
              @if (auth()->id() === $user->id)
                <a href="#" class="btn btn-outline-secondary">Settings</a>
              @else
                @php $isFollowing = auth()->user()->isFollowing($user->id); @endphp
                <form action="{{ route('follow.toggle', $user->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn {{ $isFollowing ? 'btn-outline-primary border-primary text-primary' : 'btn-outline-primary' }}">
                    {{ $isFollowing ? 'Following' : 'Follow' }}
                  </button>
                </form>
              @endif
            </div>
            <p class="mb-0">{{ $user->name }}</p>
            <small>{{ $user->bio ?? 'No bio yet' }}</small>
            <div class="mt-2">
              <span><strong>{{ $postCount }}</strong> posts</span> ·
              <span><strong>{{ $followerCount }}</strong> followers</span> ·
              <span><strong>{{ $followingCount }}</strong> following</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs -->
      <div class="tabs">
        <button class="tab-btn active" onclick="selectTab(this)">Posts</button>
        <button class="tab-btn" onclick="selectTab(this)">Likes</button>
      </div>

      <!-- Content -->
      <div class="content-box" style="background-color: transparent; justify-content: flex-start;">
        @if ($posts->isEmpty())
          <div class="text-center w-100">
            <i class="bi bi-camera" style="font-size: 3rem; color: #555;"></i>
            <h3 class="fw-bold mt-3">No posts yet</h3>
          </div>
        @else
          <div class="row row-cols-3 g-3 w-100">
            @foreach ($posts as $post)
              <div class="col">
                <a href="{{ route('posts.show', $post->id) }}">
                  <img src="{{ asset($post->image) }}" class="img-fluid rounded" style="aspect-ratio: 1 / 1; object-fit: cover; width: 100%;">
                </a>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

  </div>
</div>

<script>
  function selectTab(button) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
  }
</script>
</body>
</html>