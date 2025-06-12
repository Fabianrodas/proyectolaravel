<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Settings | Mango</title>
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

    .profile-img {
      width: 5.625rem;
      height: 5.625rem;
      object-fit: cover;
      border-radius: 50%;
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

      <div class="col-10 p-4">
        <div class="text-center mb-4">
          <img src="{{ asset('/storage/images/logo.png') }}" alt="Logo" style="height: 80px;">
          <p class="fs-4 fw-bold mt-2">Settings</p>
        </div>

        @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

        <form action="{{ url('/settings') }}" method="POST" enctype="multipart/form-data" class="row g-3">
          @csrf

          <div class="col-md-6">
            <label class="form-label">Change picture</label>
            <input type="file" name="image" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Change username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Change password</label>
            <input type="password" name="password" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Confirm password</label>
            <input type="password" name="password_confirmation" class="form-control">
          </div>

          <div class="col-12">
            <label class="form-label">Change biography</label>
            <textarea name="bio" class="form-control" rows="2">{{ old('bio', $user->bio) }}</textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label">Change name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
          </div>

          <div class="col-md-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_private" value="1" id="privateSwitch" {{ $user->is_private ? 'checked' : '' }}>
              <label class="form-check-label" for="privateSwitch">Private account</label>
            </div>
          </div>

          <div class="col-md-6">
            <button type="submit" class="btn btn-primary w-100">Confirm</button>
          </div>

          <div class="col-md-6">
            <form action="{{ route('account.delete') }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete your account?');">
              @csrf
              <button type="submit" class="btn btn-danger w-100">Delete my account</button>
            </form>
          </div>

        </form>
      </div>

    </div>
  </div>
</body>

</html>