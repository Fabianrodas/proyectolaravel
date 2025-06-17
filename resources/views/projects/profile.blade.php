<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

    .row-cols-3>.col {
      padding: 0.25rem;
    }

    .content-box {
      border: 1px solid #ccc;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      min-height: calc(100vh - 18.75rem);
      margin-top: 1rem;
    }

    .profile-img {
      width: 5.625rem;
      height: 5.625rem;
      object-fit: cover;
      border-radius: 50%;
    }

    .tabs {
      margin-top: 2rem;
      display: flex;
      gap: 0.0625rem;
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
            <a class="nav-link mb-3" href="{{ route('messages.index') }}"><i class="bi bi-chat-left-text me-2"></i>
              Messages</a>
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
        <div class="d-flex justify-content-between align-items-start">
          <div class="d-flex align-items-center">
            <img src="{{ asset($user->image ?? 'storage/images/default.jpg') }}" class="profile-img me-3"
              alt="Profile Picture">
            <div>
              <div class="d-flex align-items-center">
                <h5 class="mb-0 fw-bold me-3">{{ '@' . $user->username }}</h5>

                @if (auth()->id() === $user->id)
          <a href="{{ route('settings') }}" class="btn btn-outline-secondary">Settings</a>
        @else
        <button id="followBtn" type="button"
          data-user-id="{{ $user->id }}"
          class="btn 
            {{ $status === 'accepted' ? 'btn-outline-primary border-primary text-primary' : 
              ($status === 'pending' ? 'btn-outline-secondary' : 'btn-outline-primary') }} me-2">
          <i class="bi 
            {{ $status === 'accepted' ? 'bi-check2' : 
              ($status === 'pending' ? 'bi-clock' : 'bi-plus') }} me-1"></i>
          {{ $status === 'accepted' ? 'Following' : 
            ($status === 'pending' ? 'Requested' : 'Follow') }}
        </button>
              <a href="{{ route('messages.start', $user->id) }}"
                class="btn btn-outline-secondary {{ !$user->canBeViewedBy(auth()->id()) ? 'disabled' : '' }}">
                <i class="bi bi-chat-left-text me-1"></i> Message
              </a>
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

        @if ($user->canBeViewedBy(auth()->id()))
        <div class="tabs">
          <button class="tab-btn active" onclick="selectTab(this)">Posts</button>
          <button class="tab-btn" onclick="selectTab(this)">Likes</button>
        </div>

        <div id="postsTab" class="content-box" style="background-color: transparent; justify-content: flex-start;">
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
          <img src="{{ asset($post->image) }}" class="img-fluid rounded"
          style="aspect-ratio: 1 / 1; object-fit: cover; width: 100%;">
          </a>
        </div>
        @endforeach
          </div>
        @endif
        </div>

        <div id="likesTab" class="content-box d-none"
          style="background-color: transparent; justify-content: flex-start;">
          @if ($likedPosts->isEmpty())
        <div class="text-center w-100">
        <i class="bi bi-heart" style="font-size: 3rem; color: #555;"></i>
        <h3 class="fw-bold mt-3">No likes yet</h3>
        </div>
        @else
          <div class="row row-cols-3 g-3 w-100">
          @foreach ($likedPosts as $post)
        <div class="col">
          <a href="{{ route('posts.show', $post->id) }}">
          <img src="{{ asset($post->image) }}" class="img-fluid rounded"
          style="aspect-ratio: 1 / 1; object-fit: cover; width: 100%;">
          </a>
        </div>
        @endforeach
          </div>
        @endif
        </div>
    @else
      <div class="alert alert-info mt-3">
        This account is private. Follow to see their posts and likes.
      </div>
    @endif
      </div>
    </div>
  </div>

  <script>
    function selectTab(button) {
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      const tabs = ['postsTab', 'likesTab'];
      tabs.forEach(id => document.getElementById(id).classList.add('d-none'));

      if (button.innerText.trim() === 'Posts') {
        document.getElementById('postsTab').classList.remove('d-none');
      } else {
        document.getElementById('likesTab').classList.remove('d-none');
      }
    }
    document.getElementById('followBtn')?.addEventListener('click', function (e) {
  e.preventDefault();
  const button = this;
  const userId = button.dataset.userId;

  fetch(`/follow/${userId}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    let icon = 'bi-plus';
    let label = 'Follow';
    let classes = 'btn btn-outline-primary';

    if (data.status === 'accepted') {
      icon = 'bi-check2';
      label = 'Following';
      classes = 'btn btn-outline-primary border-primary text-primary';
    } else if (data.status === 'pending') {
      icon = 'bi-clock';
      label = 'Requested';
      classes = 'btn btn-outline-secondary';
    }

    button.className = classes + ' me-2';
    button.innerHTML = `<i class='bi ${icon} me-1'></i> ${label}`;
  })
  .catch(err => console.error('Follow error:', err));
});

  </script>
</body>

</html>