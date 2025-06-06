<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $post->user->username }}'s Post</title>
  <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden;
    }

    .left-side-buttons {
      padding-top: 30px;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
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

    .nav-link {
      font-weight: bold;
      font-size: 16px;
      color: #0d6efd;
    }

    .btn-wide {
      width: 100%;
      height: 50px;
      font-size: 20px;
      border-radius: 25px;
    }

  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar izquierda -->
    <div class="col-2 bg-light text-start ps-2">
      <div class="left-side-buttons">
        <nav class="nav flex-column">
        <img src="{{ asset(Auth::user()->image ?? 'storage/images/default.jpg') }}" class="rounded-circle mb-5 mx-auto d-block" width="80" height="80">
          <a class="nav-link mb-3 mt-3" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i> Home</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-search me-2"></i> Search</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-bell me-2"></i> Notifications</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-chat-left-text me-2"></i> Messages</a>
          <a class="nav-link mb-5" href="#"><i class="bi bi-info-circle me-2"></i> About us</a>
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

    <!-- Post principal -->
    <div class="col-7 d-flex align-items-start mt-4">
      <div class="card shadow-sm w-100 post-fixed-size">
        <div class="card-body p-4 post-content">
          <!-- Header del post -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
              <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-3" width="60" height="60">
              <strong class="fs-4">{{ $post->user->username }}</strong>
            </div>
            <button class="btn btn-outline-primary" style="font-size: 1rem;">Follow</button>
          </div>

          <!-- Imagen -->
          <div class="img-container mb-3">
            <img src="{{ asset($post->image) }}" class="img-standard rounded">
          </div>

          <!-- Contenido -->
          <p class="mb-0">{{ $post->content }}</p>

          <!-- Likes y botón -->
          <div class="like-comment-row text-dark fw-semibold fs-5 mt-auto border-top pt-3">
            <div>
              <i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes
              <i class="bi bi-chat-left-text-fill text-primary ms-3 me-1"></i> {{ $post->comments_count }} comments
            </div>
            <form action="{{ route('posts.like', $post->id) }}" method="POST" class="mb-0">
              @csrf
              <button type="submit" class="btn btn-danger px-4 fw-bold">Like</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Comentarios -->
    <div class="col-3">
      <div class="card comments-card mt-4 shadow-sm">
        <div class="card-body d-flex flex-column">
          <h5 class="text-center mb-4">Comments</h5>

          <!-- Lista scrollable -->
          <div class="comment-scroll-box">
            @forelse ($post->comments as $comment)
              <div class="comment-item">
                <div class="d-flex align-items-center mb-2">
                  <img src="{{ asset($comment->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-2" width="30" height="30">
                  <strong>{{ $comment->user->username }}</strong>
                </div>
                <p class="mb-1">{{ $comment->content }}</p>
              </div>
            @empty
              <p class="text-muted">No comments yet.</p>
            @endforelse
          </div>

          <!-- Input comentario -->
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
</body>
</html>