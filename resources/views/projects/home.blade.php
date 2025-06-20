<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Home | Mango</title>
  <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">

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

    #recentSection,
    #popularSection,
    #sidebarRecent,
    #sidebarPopular {
      transition: opacity 0.3s ease-in-out;
    }

    .post-link {
      text-decoration: none;
      color: inherit;
    }

    .img-fluid-standard {
      max-height: 28.125rem;
      width: auto;
      object-fit: contain;
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

      <div class="col-7 overflow-auto" style="height: 100vh;">
        <div class="text-center my-3">
          <a href="/home">
            <img src="/storage/images/logo.png" width="120" height="120">
          </a>
        </div>

        <div class="text-center mb-3">
          <div class="btn-group" role="group">
            <button class="btn btn-outline-primary active" id="btnRecent" onclick="showRecent()">Recent Posts</button>
            <button class="btn btn-outline-primary" id="btnPopular" onclick="showPopular()">Popular Posts</button>
          </div>
        </div>

        <div id="recentSection">
          @foreach ($recentPosts as $post)
          <div class="card mb-4 shadow-sm">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                  <a href="{{ route('users.profile', $post->user->id) }}">
                    <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-3" width="60" height="60">
                  </a>
                  <strong class="fs-4">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                      {{ $post->user->username }}
                    </a>
                  </strong>
                </div>
                @if(auth()->id() !== $post->user->id)
                @php $isFollowing = auth()->user()->isFollowing($post->user->id); @endphp
                <button class="btn {{ $isFollowing ? 'btn-outline-primary border-primary text-primary' : 'btn-outline-primary' }} follow-btn" data-user-id="{{ $post->user->id }}">
                  <i class="bi {{ $isFollowing ? 'bi-check2' : 'bi-plus' }} me-1"></i>
                  {{ $isFollowing ? 'Following' : 'Follow' }}
                </button>
                @endif
              </div>

              <div class="text-center mb-3">
                <a href="{{ route('posts.show', $post->id) }}">
                  <img src="{{ asset($post->image) }}" class="img-fluid rounded img-fluid-standard">
                </a>
              </div>
              <p>{{ $post->content }}</p>
              <div class="border-top pt-3">
                <div class="d-flex text-dark fw-semibold fs-5 mb-3">
                  <div class="me-4"><i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes</div>
                  <div><i class="bi bi-chat-left-text-fill text-primary me-1"></i> {{ $post->comments_count }} comments</div>
                </div>
                <div class="d-flex gap-2">
                  <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form w-100">
                    @csrf
                    <input type="text" name="content" class="form-control" placeholder="Add a comment" required>
                  </form>
                  @php $liked = $post->likes->contains(auth()->id()); @endphp
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
          @endforeach
        </div>

        <div id="popularSection" style="display: none;">
          @foreach ($popularPosts as $post)
        <div class="card mb-4 shadow-sm">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex align-items-center">
            <a href="{{ route('users.profile', $post->user->id) }}">
            <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}"
              class="rounded-circle me-3" width="60" height="60">
            </a>
            <strong class="fs-4">
            <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
              {{ $post->user->username }}
            </a>
            </strong>
          </div>
          @if(auth()->id() !== $post->user->id)
        @php $isFollowing = auth()->user()->isFollowing($post->user->id); @endphp
        <button
          class="btn {{ $isFollowing ? 'btn-outline-primary border-primary text-primary' : 'btn-outline-primary' }} follow-btn"
          data-user-id="{{ $post->user->id }}">
          <i class="bi {{ $isFollowing ? 'bi-check2' : 'bi-plus' }} me-1"></i>
          {{ $isFollowing ? 'Following' : 'Follow' }}
        </button>
      @endif
          </div>
          <div class="text-center mb-3">
          <a href="{{ route('posts.show', $post->id) }}">
            <img src="{{ asset($post->image) }}" class="img-fluid rounded img-fluid-standard">
          </a>
          </div>
          <p>{{ $post->content }}</p>
          <div class="border-top pt-3">
          <div class="d-flex text-dark fw-semibold fs-5 mb-3">
            <div class="me-4"><i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes
            </div>
            <div><i class="bi bi-chat-left-text-fill text-primary me-1"></i> {{ $post->comments_count }} comments
            </div>
          </div>
          <div class="d-flex gap-2">
            <input type="text" class="form-control" placeholder="Add a comment">
            @php $liked = $post->likes->contains(auth()->id()); @endphp
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
      @endforeach
        </div>
      </div>

      <div class="col-3">
        <div id="sidebarPopular" class="right-sidebar">
          <div class="card mt-4">
            <div class="card-body">
              <h5 class="mb-4 card-title text-center">Popular Posts</h5>
              @foreach ($popularPosts->take(3) as $post)
          <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
          <div class="mb-4 border-bottom pb-3">
            <div class="d-flex align-items-center mb-2">
            <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}"
              class="rounded-circle me-2" width="25" height="25">
            <strong style="font-size: 14px;">{{ $post->user->username }}</strong>
            </div>
            <div class="text-center mb-2">
            <img src="{{ asset($post->image) }}" class="img-fluid rounded"
              style="max-height: 80px; width: auto;">
            </div>
            <div class="text-dark fw-semibold" style="font-size: 13px;">
            <i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes
            · <i class="bi bi-chat-left-text-fill text-primary ms-2 me-1"></i> {{ $post->comments_count }}
            comments
            </div>
          </div>
          </a>
        @endforeach
            </div>
          </div>
        </div>

        <div id="sidebarRecent" class="right-sidebar" style="display: none;">
          <div class="card mt-4">
            <div class="card-body">
              <h5 class="mb-4 card-title text-center">Recent Posts</h5>
              @foreach ($recentPosts->take(3) as $post)
          <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
          <div class="mb-4 border-bottom pb-3">
            <div class="d-flex align-items-center mb-2">
            <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}"
              class="rounded-circle me-2" width="25" height="25">
            <strong style="font-size: 14px;">{{ $post->user->username }}</strong>
            </div>
            <div class="text-center mb-2">
            <img src="{{ asset($post->image) }}" class="img-fluid rounded"
              style="max-height: 80px; width: auto;">
            </div>
            <div class="text-dark fw-semibold" style="font-size: 13px;">
            <i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes
            · <i class="bi bi-chat-left-text-fill text-primary ms-2 me-1"></i> {{ $post->comments_count }}
            comments
            </div>
          </div>
          </a>
        @endforeach
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script>
    document.querySelectorAll('.follow-btn').forEach(btn => {
      btn.addEventListener('click', function (e) {
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
          location.reload(); 
        })
        .catch(err => {
          console.error('Error:', err);
          location.reload();
        });
      });
    });
  </script>
  <script>
    function showRecent() {
      document.getElementById('recentSection').style.opacity = '0';
      document.getElementById('popularSection').style.opacity = '0';
      document.getElementById('sidebarRecent').style.opacity = '0';
      document.getElementById('sidebarPopular').style.opacity = '0';

      setTimeout(() => {
        document.getElementById('recentSection').style.display = 'block';
        document.getElementById('popularSection').style.display = 'none';
        document.getElementById('sidebarPopular').style.display = 'block';
        document.getElementById('sidebarRecent').style.display = 'none';

        document.getElementById('recentSection').style.opacity = '1';
        document.getElementById('sidebarPopular').style.opacity = '1';

        document.getElementById('btnRecent').classList.add('active');
        document.getElementById('btnPopular').classList.remove('active');
      }, 150);
    }

    function showPopular() {
      document.getElementById('recentSection').style.opacity = '0';
      document.getElementById('popularSection').style.opacity = '0';
      document.getElementById('sidebarRecent').style.opacity = '0';
      document.getElementById('sidebarPopular').style.opacity = '0';

      setTimeout(() => {
        document.getElementById('recentSection').style.display = 'none';
        document.getElementById('popularSection').style.display = 'block';
        document.getElementById('sidebarPopular').style.display = 'none';
        document.getElementById('sidebarRecent').style.display = 'block';

        document.getElementById('popularSection').style.opacity = '1';
        document.getElementById('sidebarRecent').style.opacity = '1';

        document.getElementById('btnRecent').classList.remove('active');
        document.getElementById('btnPopular').classList.add('active');
      }, 150);
    }
  </script>
  <script>
  document.querySelectorAll('.comment-form').forEach(form => {
    const input = form.querySelector('input[name="content"]');
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        if (this.value.trim() !== '') {
          form.submit();
        }
      }
    });
  });
</script>
</body>

</html>