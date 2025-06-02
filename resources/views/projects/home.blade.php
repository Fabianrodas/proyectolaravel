<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mango Home</title>

    <!-- Styles -->
    <style>
      .left-side-buttons {
        padding-top: 30px;
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
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  </head>
  <body>

    <div class="container-fluid">
      <div class="row">

        <!-- Left sidebar -->
        <div class="col-2 bg-light text-start ps-2">
          <div class="left-side-buttons">
            <nav class="nav flex-column">
              <img src="/storage/images/default.jpg" class="rounded-circle mb-5 mx-auto d-block" width="80" height="80">
              <a class="nav-link mb-3 mt-3" href="#">
                <i class="bi bi-house-door me-2"></i> Home
              </a>
              <a class="nav-link mb-3" href="#">
                <i class="bi bi-search me-2"></i> Search
              </a>
              <a class="nav-link mb-3" href="#">
                <i class="bi bi-bell me-2"></i> Notifications
              </a>
              <a class="nav-link mb-3" href="#">
                <i class="bi bi-chat-left-text me-2"></i> Messages
              </a>
              <a class="nav-link mb-5" href="#">
                <i class="bi bi-info-circle me-2"></i> About us
              </a>
              <div class="buttons d-grid gap-2">
                <button class="btn btn-outline-dark">Post</button>
                <button class="btn btn-outline-dark">Log Out</button>
              </div>
            </nav>
          </div>
        </div>

        <!-- Main content -->
        <div class="col-7">

          <!-- Logo + toggle -->
          <div class="text-center">
            <img src="/storage/images/logo.png" width="120" height="120">
          </div>
          <div class="mb-3 text-center">
            <div class="btn-group" role="group" aria-label="Post filters">
              <input type="radio" class="btn-check" name="postToggle" id="recentToggle" autocomplete="off" checked>
              <label class="btn btn-outline-primary" for="recentToggle">Recent Posts</label>
              <input type="radio" class="btn-check" name="postToggle" id="popularToggle" autocomplete="off">
              <label class="btn btn-outline-primary" for="popularToggle">Popular Posts</label>
            </div>
          </div>

          <!-- Post -->
          <div class="card mb-4 shadow-sm">
            <div class="card-body p-4">

              <!-- User info -->
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                  <img src="/storage/images/default.jpg" class="rounded-circle me-3" width="60" height="60">
                  <strong class="fs-4 ps-1">Username</strong>
                </div>
                <button class="btn btn-outline-primary" style="font-size: 1.1rem; padding: 10px 20px; border-radius: 10px;">
                  Follow
                </button>
              </div>

              <!-- Post image -->
              <div class="mb-3">
                <img src="/storage/images/post.png" class="mx-auto d-block w-75">
              </div>

              <!-- Post content -->
              <p class="mb-3">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae elit nec urna tincidunt.
              </p>

              <!-- Likes + comments + input -->
              <div class="border-top pt-3">
                <div class="d-flex text-muted mb-2">
                  <div class="me-4">❤️ 12 likes</div>
                  <div>💬 4 comments</div>
                </div>
                <input type="text" class="form-control" placeholder="Add a comment">
              </div>

            </div>
          </div>

        </div>

        <!-- Right sidebar -->
        <div class="col-3">
          <div class="card mt-4">
            <div class="card-body">
              <h5 class="mb-4 card-title">Popular Posts</h5>

              <!-- Popular post -->
              <div class="mb-3 border-bottom pb-2">
                <div class="d-flex align-items-center mb-1">
                  <img src="/storage/images/default.jpg" class="rounded-circle me-2" width="30" height="30">
                  <strong>username</strong>
                </div>
                <div class="mb-3">
                  <img src="/storage/images/post.png" class="mt-2 mb-2 mx-auto d-block" width="200">
                </div>
                <div class="text-muted" style="font-size: 13px;">
                  ❤️ 34 likes · 💬 5 comments
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>