<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mango Home</title>
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
    .right-sidebar {
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }
    .buttons {
      display: flex;
      flex-direction: column;
      gap: 30px;
      margin-top: 75px;
    }
    .btn-post, .btn-logout {
      color: black;
      width: 150px;
      height: 60px;
      border-radius: 25px;
      font-size: 20px;
    }
    .nav-link {
      font-weight: bold;
      font-size: 16px;
      color: #0d6efd;
    }
  #recentSection,
#popularSection,
#sidebarRecent,
#sidebarPopular {
  transition: opacity 0.3s ease-in-out;
}
</style>
</head>
<body>
<div class="container-fluid">
  <div class="row">

    <div class="col-2 bg-light text-start ps-2">
      <div class="left-side-buttons">
        <nav class="nav flex-column">
          <img src="/storage/images/default.jpg" class="rounded-circle mb-5 mx-auto d-block" width="80" height="80">
          <a class="nav-link mb-3 mt-3" href="#"><i class="bi bi-house-door me-2"></i> Home</a>
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
                  <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-3" width="60" height="60">
                  <strong class="fs-4">{{ $post->user->username }}</strong>
                </div>
                <button class="btn btn-outline-primary" style="font-size: 1.1rem; padding: 10px 20px; border-radius: 10px;">Follow</button>
              </div>
              <div class="text-center mb-3">
                <img src="{{ asset($post->image) }}" class="img-fluid rounded">
              </div>
              <p>{{ $post->content }}</p>
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
        @endforeach
      </div>

      <div id="popularSection" style="display: none;">
        @foreach ($popularPosts as $post)
          <div class="card mb-4 shadow-sm">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                  <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-3" width="60" height="60">
                  <strong class="fs-4">{{ $post->user->username }}</strong>
                </div>
                <button class="btn btn-outline-primary" style="font-size: 1.1rem; padding: 10px 20px; border-radius: 10px;">Follow</button>
              </div>
              <div class="text-center mb-3">
                <img src="{{ asset($post->image) }}" class="img-fluid rounded">
              </div>
              <p>{{ $post->content }}</p>
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
        @endforeach
      </div>
    </div>

    <div class="col-3">
      <div id="sidebarPopular" class="right-sidebar">
        <div class="card mt-4">
          <div class="card-body">
            <h5 class="mb-4 card-title text-center">Popular Posts</h5>
            @foreach ($popularPosts->take(3) as $post)
              <div class="mb-4 border-bottom pb-3">
                <div class="d-flex align-items-center mb-2">
                  <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-2" width="25" height="25">
                  <strong style="font-size: 14px;">{{ $post->user->username }}</strong>
                </div>
                <div class="text-center mb-2">
                  <img src="{{ asset($post->image) }}" class="img-fluid rounded" style="max-height: 80px; width: auto;">
                </div>
                <div class="text-dark fw-semibold" style="font-size: 13px;">
                  <i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes
                  · <i class="bi bi-chat-left-text-fill text-primary ms-2 me-1"></i> {{ $post->comments_count }} comments
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div id="sidebarRecent" class="right-sidebar" style="display: none;">
        <div class="card mt-4">
          <div class="card-body">
            <h5 class="mb-4 card-title text-center">Recent Posts</h5>
            @foreach ($recentPosts->take(3) as $post)
              <div class="mb-4 border-bottom pb-3">
                <div class="d-flex align-items-center mb-2">
                  <img src="{{ asset($post->user->image ?? '/storage/images/default.jpg') }}" class="rounded-circle me-2" width="25" height="25">
                  <strong style="font-size: 14px;">{{ $post->user->username }}</strong>
                </div>
                <div class="text-center mb-2">
                  <img src="{{ asset($post->image) }}" class="img-fluid rounded" style="max-height: 80px; width: auto;">
                </div>
                <div class="text-dark fw-semibold" style="font-size: 13px;">
                  <i class="bi bi-heart-fill text-danger me-1"></i> {{ $post->likes_count }} likes
                  · <i class="bi bi-chat-left-text-fill text-primary ms-2 me-1"></i> {{ $post->comments_count }} comments
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
