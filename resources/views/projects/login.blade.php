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
      background-color: #f8f9fa;
    }

    .container-fluid {
      height: 100vh;
    }

    .left-image {
      background: #f8f9fa url('/storage/images/mango.png') no-repeat;
      background-size: 80%;
      background-position: 100% 20%;
      height: 100%;
      min-height: 700px;
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
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row h-100">
    
    <div class="col-md-6 left-image"></div>

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
            <input type="text" name="login" class="form-control" placeholder="Username or email" value="{{ old('login') }}" required autofocus>
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
