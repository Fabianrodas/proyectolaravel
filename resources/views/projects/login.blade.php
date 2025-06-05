<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Mango</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body, html {
      height: 100%;
      margin: 0;
    }

    .container-fluid {
      height: 100vh;
    }

    .left-image {
      background: url('/storage/images/mango.png') no-repeat center center;
      background-size: cover;
      height: 100%;
    }

    .login-section {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
      background-color: #f8f9fa;
    }

    .login-card {
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .login-card h2 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 1.5rem;
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-primary {
      border-radius: 10px;
      font-weight: bold;
    }

    .text-link {
      margin-top: 1rem;
      text-align: center;
    }

    .text-link a {
      color: #0d6efd;
      text-decoration: none;
    }

    .text-link a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .left-image {
        display: none;
      }
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row h-100">
    
    <div class="col-md-6 left-image">
    </div>

    <div class="col-md-6 login-section">
      <div class="login-card">
        <div class="text-center mb-3">
          <img src="/storage/images/logo.png" alt="Mango Logo" width="80" height="80">
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
            <input type="text" name="login" class="form-control" placeholder="Username or email" value="{{ old('login') }}" required autofocus>
          </div>
          <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>

        <div class="text-link">
          Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
