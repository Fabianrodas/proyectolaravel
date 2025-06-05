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
    .left-side-buttons {
      padding-top: 30px;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }

    .btn-post, .btn-logout {
      color: black;
      width: 150px;
      height: 60px;
      border-radius: 25px;
      font-size: 20px;
    }

    .buttons {
      display: flex;
      flex-direction: column;
      gap: 30px;
      margin-top: 75px;
    }

    .nav-link {
      font-weight: bold;
      font-size: 16px;
      color: #0d6efd;
    }

    .comments-card {
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .comment-scroll-box {
      flex-grow: 1;
      overflow-y: auto;
      padding-right: 5px;
    }

    .comment-input {
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }

    .comment-item {
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .rounded-img {
      object-fit: cover;
      width: 60px;
      height: 60px;
    }

    .post-img {
      max-height: 500px;
      object-fit: contain;
    }

    .card-body {
      padding: 1.5rem;
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
          <img src="/storage/images/default.jpg" class="rounded-circle mb-5 mx-auto d-block" width="80" height="80">
          <a class="nav-link mb-3 mt-3" href="/home"><i class="bi bi-house-door me-2"></i> Home</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-search me-2"></i> Search</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-bell me-2"></i> Notifications</a>
          <a class="nav-link mb-3" href="#"><i class="bi bi-chat-left-text me-2"></i> Messages</a>
          <a class="nav-link mb-5" href="#"><i class="bi bi-info-circle me-2"></i> About us</a>
          <div class="buttons d-grid gap-2">
            <button class="btn btn-outline-dark">Post</button>
            <button class="btn btn-outline-dark">Log Out</button>
          </div>
        </nav>
      </div>
    </div>

    <!-- Post principal -->
    <div class="col-7">
      <div class="card shadow-sm mt-4" id="postCard">
        <div class="card-body">
          <!-- Header del post -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
              <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-3" width="60" height="60">
              <strong class="fs-4">{{ $post->user->username }}</strong>
            </div>
            <button class="btn btn-outline-primary" style="font-size: 1rem;">Follow</button>
          </div>

          <!-- Imagen -->
          <div class="text-center mb-3">
            <img src="{{ asset($post->image) }}" class="img-fluid rounded post-img">
          </div>

          <!-- Contenido -->
          <p>{{ $post->content }}</p>

          <!-- Likes y comentarios -->
          <div class="border-top pt-3">
            <div class="d-flex text-dark fw-semibold fs-5 mb-3">
              <div class="me-4"><i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes</div>
              <div><i class="bi bi-chat-left-text-fill text-primary me-1"></i> {{ $post->comments_count }} comments</div>
            </div>
            <div class="d-flex gap-2">
              <input type="text" class="form-control" placeholder="Add a comment">
              <button class="btn btn-danger px-4 fw-bold">Like</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Comentarios -->
    <div class="col-3">
      <div class="card mt-4 shadow-sm comments-card" id="commentsCard">
        <div class="card-body d-flex flex-column">
          <h5 class="text-center mb-3">Comments</h5>

          <!-- Scroll interno -->
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

          <!-- Input comentario fijo abajo -->
          <div class="comment-input pt-3">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Add a comment">
              <button class="btn btn-outline-primary">Post</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  function matchCommentCardHeight() {
    const postCard = document.getElementById('postCard');
    const commentsCard = document.getElementById('commentsCard');
    if (postCard && commentsCard) {
      commentsCard.style.height = `${postCard.offsetHeight}px`;
    }
  }

  window.addEventListener('load', matchCommentCardHeight);
  window.addEventListener('resize', matchCommentCardHeight);
</script>
</body>
</html>