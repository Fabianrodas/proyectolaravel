<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Post</title>
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

    .btn-submit {
      background-color: #0d6efd;
      color: white;
      font-weight: bold;
      padding: 0.6rem 2rem;
      border-radius: 1.5rem;
      font-size: 1rem;
    }

    .form-area {
      height: 100vh;
      overflow-y: auto;
    }

    .form-card {
      max-width: 56.25rem;
      margin: auto;
      width: 100%;
    }

    .preview-box {
      width: 100%;
      height: 25rem;
      border: 0.125rem dashed #ccc;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f8f9fa;
      position: relative;
    }

    .preview-box img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      display: none;
    }

    .preview-box span {
      color: #999;
      font-size: 1.2rem;
    }

    @media (max-width: 768px) {
      .form-card {
        flex-direction: column;
      }
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

      <div class="col-10 form-area d-flex align-items-center justify-content-center">
        <div class="card shadow-sm form-card p-4">
          <h3 class="mb-4 text-center">Create a New Post</h3>

          <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="col-md-6 mb-4">
                <label for="image" class="form-label">Image Preview</label>
                <div class="preview-box" onclick="document.getElementById('image').click()">
                  <img id="previewImage" alt="Preview">
                  <span id="placeholderText">Click to select image</span>
                </div>
                <input type="file" name="image" id="image" accept="image/*" class="form-control d-none" required>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="content" class="form-label">Content</label>
                  <textarea class="form-control" name="content" id="content" rows="10"
                    required>{{ old('content') }}</textarea>
                </div>

                <div class="text-end mt-3">
                  <button type="submit" class="btn btn-submit">Post</button>
                </div>
              </div>
            </div>
          </form>

          @if ($errors->any())
        <div class="alert alert-danger mt-4">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
        </ul>
        </div>
      @endif
        </div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const input = document.getElementById('image');
      const preview = document.getElementById('previewImage');
      const placeholder = document.getElementById('placeholderText');

      input.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
          };
          reader.readAsDataURL(file);
        }
      });
    });
  </script>

</body>

</html>