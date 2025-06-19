<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Mango</title>
  <link rel="icon" href="{{ asset('mangoico.ico') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body,
    html {
      height: 100%;
      margin: 0;
      background-color: #f8f9fa;
    }

    .container-fluid {
      height: 100vh;
    }

    .login-section {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .login-card {
      width: 400px;
      padding: 2rem;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      display: flex;
      flex-direction: column;
      min-height: 480px;
    }

    .login-card h2 {
      text-align: center;
      font-weight: bold;
      font-size: 1.7rem;
      margin-bottom: 1.5rem;
    }

    .form-control {
      border-radius: 8px;
      font-size: 0.95rem;
      padding: 0.6rem 1rem;
    }

    .btn-primary {
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.95rem;
      padding: 0.55rem;
    }

    .divider {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 1.5rem 0 1rem;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #ccc;
    }

    .divider span {
      margin: 0 10px;
      width: 10px;
      height: 10px;
      background: #ccc;
      border-radius: 50%;
      display: inline-block;
    }

    .signup-link {
      text-align: center;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .signup-link a {
      color: #0d6efd;
      text-decoration: none;
      font-weight: 500;
    }

    .signup-link a:hover {
      text-decoration: underline;
    }

    .footer {
      text-align: center;
      font-size: 0.85rem;
      color: #999;
      margin-top: auto;
      padding-top: 1rem;
    }

    @media (max-width: 768px) {
      .left-image {
        display: none;
      }

      .login-card {
        width: 90%;
        padding: 1.5rem;
      }

      .login-card h2 {
        font-size: 1.5rem;
      }

      .form-control {
        font-size: 0.9rem;
      }

      .btn-primary {
        font-size: 0.9rem;
      }
    }
    
    .carousel-img {
      width: 400px;
      height: 600px;
      object-fit: contain;
    }

    #myCarousel {
      margin-left: 70px;
    }
  </style>
</head>

<body>
    
  <div class="container-fluid">
    <div class="row h-100">
      <div class="col-6 d-flex align-items-center justify-content-center">
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="/storage/images/mango.png" class="d-block w-100 carousel-img" alt="Slide 1">
            </div>
            <div class="carousel-item">
              <img src="/storage/images/mango2.png" class="d-block w-100 carousel-img" alt="Slide 2">
            </div>
            <div class="carousel-item">
              <img src="/storage/images/mango3.png" class="d-block w-100 carousel-img" alt="Slide 3">
            </div>
            <div class="carousel-item">
              <img src="/storage/images/mango4.png" class="d-block w-100 carousel-img" alt="Slide 4">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="col-md-6 login-section">
        <div class="login-card d-flex flex-column">
          <div class="text-center mb-4">
            <img src="/storage/images/logo.png" alt="Mango Logo" width="70" height="70">
          </div>
          <h2>Sign In</h2>

          @if ($errors->any())
        <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
        </ul>
        </div>
      @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <input type="text" name="login" class="form-control" placeholder="Username or email"
                value="{{ old('login') }}" required autofocus>
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </form>

          <div class="divider">
            <span></span>
          </div>

          <div class="signup-link">
            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
          </div>

          <div class="footer">
            © 2025 Mango
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>