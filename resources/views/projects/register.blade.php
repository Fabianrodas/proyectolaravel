<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | Mango</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      background-color: #f8f9fa;
    }

    .container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .register-card {
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      padding: 2rem;
      max-width: 800px;
      width: 100%;
    }

    .form-control {
      border-radius: 10px;
      font-size: 0.95rem;
    }

    .btn-primary {
      border-radius: 10px;
      font-weight: bold;
      padding: 0.6rem;
    }

    .form-switch .form-check-input {
      width: 3em;
      height: 1.5em;
    }

    .footer {
      text-align: center;
      font-size: 0.85rem;
      color: #999;
      margin-top: 1.5rem;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="register-card">
    <div class="text-center mb-4">
      <img src="/storage/images/logo.png" alt="Mango Logo" width="70" height="70">
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
      @csrf

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <input type="text" name="name" class="form-control" placeholder="Complete Name" required>
        </div>
        <div class="col-md-6">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="col-md-6">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="col-md-6">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
        </div>

        <div class="col-md-6">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-6 d-flex align-items-center">
          <label class="form-check-label me-2" for="is_private">Private account</label>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_private" id="is_private">
          </div>
        </div>

        <div class="col-md-6">
          <input type="file" name="image" class="form-control">
        </div>
      </div>

      <p class="text-muted" style="font-size: 0.85rem;">
        People who use our service may have uploaded your contact information to Mango ©. More information.<br>
        By clicking "Sign up", you agree to our Terms, Privacy Policy and Cookies Policy. We may send you SMS notifications, which you can turn off at any time.
      </p>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </div>

      <div class="text-center mt-3">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
      </div>

      <div class="footer">
        © 2025 Mango
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
