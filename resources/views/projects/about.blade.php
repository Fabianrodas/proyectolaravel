<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us | Mango</title>
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

    .about-section {
      padding: 2rem;
    }

    .about-image {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
      <div class="col-10 about-section">
        <h2 class="fw-bold mb-4 text-center">About Us</h2>

        <div class="row align-items-center mb-5">
          <div class="col-md-6">
            <h4 class="fw-bold mb-3">Our History</h4>
            <p class="lead">
              We are a dedicated team of computer science students who, through weeks of planning, collaboration, and
              continuous refinement, brought this project to life using the Laravel framework. Our goal was not just to
              build a functional application, but to challenge ourselves by applying industry-level standards and
              practices. Every feature, from design to implementation, reflects the commitment and learning we gained
              throughout this journey. This project represents both our technical growth and the collective effort of a
              team passionate about building quality software.
            </p>
          </div>
          <div class="col-md-6 text-center">
            <img src="{{ asset('storage/images/post.png') }}" alt="Profe ponganos 100" class="about-image">
          </div>
        </div>

        <div class="text-center my-5">
          <h4 class="fw-bold mb-4">Group Members</h4>
          <div class="row justify-content-center">
            <div class="col-md-4 mb-5">
              <h5>Roberto Falquez</h5>
              <a href="https://github.com/rfalquezg" target="_blank" class="btn btn-dark btn-sm mb-2">GitHub Account</a>
              <div class="mt-3">
                <img src="{{ asset('storage/images/yo.jpeg') }}" alt="Roberto" class="profile-img" height="250px"
                  width="250px">
              </div>
            </div>
            <div class="col-md-4 mb-5">
              <h5>Fabián Rodas</h5>
              <a href="https://github.com/Fabianrodas" target="_blank" class="btn btn-dark btn-sm mb-2">GitHub
                Account</a>
              <div class="mt-3">
                <img src="{{ asset('storage/images/Fabian.png') }}" alt="Fabián" class="profile-img" height="250px"
                  width="250px">
              </div>
            </div>
            <div class="col-md-4 mb-5">
              <h5>Paula Benalcázar</h5>
              <a href="https://github.com/paulabenalcazart" target="_blank" class="btn btn-dark btn-sm mb-2">GitHub
                Account</a>
              <div class="mt-3">
                <img src="{{ asset('storage/images/Paula.jpg') }}" alt="Paula" class="profile-img" height="250px"
                  width="250px">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>

</html>