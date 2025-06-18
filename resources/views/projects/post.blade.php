<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $post->user->username }}'s Post</title>
  <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      overflow: hidden;
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

    .post-fixed-size {
      height: 90vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .post-content {
      flex-grow: 1;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .img-container {
      flex: 1;
      max-height: 380px;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .img-standard {
      max-height: 100%;
      max-width: 100%;
      object-fit: contain;
    }

    .like-comment-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1rem;
    }

    .comments-card {
      height: 90vh;
      display: flex;
      flex-direction: column;
    }

    .comment-scroll-box {
      flex-grow: 1;
      overflow-y: auto;
      margin-bottom: 1rem;
    }

    .comment-item {
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .comment-input {
      margin-top: auto;
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
            <a class="nav-link mb-3" href="{{ route('notifications') }}"><i class="bi bi-bell me-2"></i>
              Notifications</a>
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

      <div class="col-7 d-flex align-items-start mt-4">
        <div class="card shadow-sm w-100 post-fixed-size">
          <div class="card-body p-4 post-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex align-items-center">
                <a href="{{ route('users.profile', $post->user->id) }}">
                  <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}"
                    class="rounded-circle me-3" width="60" height="60">
                </a>
                <strong class="fs-4">{{ $post->user->username }}</strong>
              </div>
              @if(auth()->id() !== $post->user->id)
              @php
            $relationship = auth()->user()->followings()->where('followed_id', $post->user->id)->first();
            $status = $relationship ? $relationship->pivot->status : null;
          @endphp

              <button id="followBtn" type="button" data-user-id="{{ $post->user->id }}" class="btn 
                    {{ $status === 'accepted' ? 'btn-outline-primary border-primary text-primary' :
        ($status === 'pending' ? 'btn-outline-secondary' : 'btn-outline-primary') }}">
              <i class="bi 
                    {{ $status === 'accepted' ? 'bi-check2' :
        ($status === 'pending' ? 'bi-clock' : 'bi-plus') }} me-1"></i>
              {{ $status === 'accepted' ? 'Following' :
        ($status === 'pending' ? 'Requested' : 'Follow') }}
              </button>
        @endif
            </div>

            <div class="img-container mb-3">
              <img src="{{ asset($post->image) }}" class="img-standard rounded">
            </div>

            <p class="mb-0">{{ $post->content }}</p>

            <div class="like-comment-row text-dark fw-semibold fs-5 mt-auto border-top pt-3">
              <div>
                <i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes
                <i class="bi bi-chat-left-text-fill text-primary ms-3 me-1"></i> {{ $post->comments_count }} comments
              </div>
              @php
        $liked = $post->likes->contains(auth()->id());
        @endphp

              <form action="{{ route('posts.like', $post->id) }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn {{ $liked ? 'btn-outline-danger' : 'btn-danger' }} px-4 fw-bold">
                  {{ $liked ? 'Liked' : 'Like' }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-3">
        <div class="card comments-card mt-4 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="text-center mb-4">Comments</h5>

            <div class="comment-scroll-box">
              @forelse ($post->comments as $comment)
          <div class="comment-item">
          <div class="d-flex align-items-center mb-2">
            <a href="{{ route('users.profile', $comment->user->id) }}">
            <img src="{{ asset($comment->user->image ?? '/storage/images/default.jpg') }}"
              class="rounded-circle me-2" width="30" height="30">
            </a>
            <strong>{{ $comment->user->username }}</strong>
          </div>
          <p class="mb-1">{{ $comment->content }}</p>
          </div>
        @empty
          <p class="text-muted">No comments yet.</p>
        @endforelse
            </div>

            <div class="comment-input pt-3">
              <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="input-group">
                  <input type="text" name="content" class="form-control" placeholder="Add a comment" required>
                  <button class="btn btn-outline-primary" type="submit">Post</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
  <script>
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

          button.className = classes;
          button.innerHTML = `<i class='bi ${icon} me-1'></i> ${label}`;
        })
        .catch(err => console.error('Follow error:', err));
    });
  </script>

</body>

</html>