{{-- search.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Search | Mango</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">
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
      margin: 0 auto;
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

    .search-input,
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

      <div class="col-10 py-4">
        <div class="text-center">
          <img src="{{ asset('storage/images/logo.png') }}" alt="Mango Logo" class="logo-mango mb-3">
        </div>

        <div class="search-box mb-4">
          <form method="GET" action="{{ route('search') }}" class="d-flex justify-content-center">
            <input type="text" name="search" class="form-control w-50 me-2 search-input" placeholder="Search users..."
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
          <img src="{{ asset($user->image ?? 'storage/images/default.jpg') }}" class="rounded-circle me-3"
          width="60" height="60">
          </a>
          <div>
          <h5 class="mb-0">{{ $user->username }}</h5>
          <small>{{ $user->name }}</small><br>
          <small class="text-muted">{{ $user->followers()->wherePivot('status', 'accepted')->count() }}
          followers</small>
          </div>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if(Auth::id() !== $user->id)
          @php
        $relationship = auth()->user()->followings()->where('followed_id', $user->id)->first();
        $status = $relationship ? $relationship->pivot->status : null;
        @endphp

          <button type="button"
          class="follow-btn btn {{ $status === 'accepted' ? 'btn-outline-primary border-primary text-primary' : ($status === 'pending' ? 'btn-outline-secondary' : 'btn-outline-primary') }}"
          data-user-id="{{ $user->id }}">
          <i
          class="bi {{ $status === 'accepted' ? 'bi-check2' : ($status === 'pending' ? 'bi-clock' : 'bi-plus') }} me-1"></i>
          {{ $status === 'accepted' ? 'Following' : ($status === 'pending' ? 'Requested' : 'Follow') }}
          </button>

          <a href="{{ route('messages.start', $user->id) }}"
          class="btn btn-outline-secondary {{ !$user->canBeViewedBy(auth()->id()) ? 'disabled' : '' }}">
          <i class="bi bi-chat-left-text me-1"></i> Message
          </a>
        @else
        <span class="badge bg-secondary this-you-badge">This is you <i class="bi bi-person-fill ms-1"></i></span>
        @endif
        </div>
        </div>
        </div>
      @endforeach
    @elseif(!empty($query))
      <div class="alert alert-info text-center">No users found for "{{ $query }}"</div>
    @endif
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
            if (!data.status) {
              location.reload();
              return;
            }

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
            } else {
              location.reload();
              return;
            }

            button.className = classes + ' me-2 follow-btn';
            button.innerHTML = `<i class='bi ${icon} me-1'></i> ${label}`;
          })
          .catch(err => console.error('Follow error:', err));
      });
    });
  </script>


</body>

</html>