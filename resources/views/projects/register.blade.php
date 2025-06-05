<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | Mango</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f6fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .form-control {
      border-radius: 10px;
    }

    .form-label {
      font-weight: 600;
    }

    .logo {
      display: block;
      margin: 0 auto 15px;
      width: 40px;
    }

    .circle-image {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background-color: #eaeaea;
      object-fit: cover;
      display: block;
      margin: 0 auto 5px;
    }

    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 25px;
    }

    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0;
      right: 0; bottom: 0;
      background-color: #ccc;
      transition: .4s;
      border-radius: 25px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 19px; width: 19px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #007bff;
    }

    input:checked + .slider:before {
      transform: translateX(24px);
    }

    .error-box {
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 15px;
      color: #721c24;
    }

    .btn-primary {
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 40px;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .btn-upload {
      background-color: #007bff;
      color: white;
      font-weight: 500;
      padding: 6px 14px;
      border-radius: 8px;
      border: none;
    }

    .btn-upload:hover {
      background-color: #0056b3;
    }

    .footer-text {
      font-size: 0.9rem;
      color: #999;
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card col-lg-10">

    <img src="/storage/images/logo.png" alt="Mango Logo" class="logo">
    <h2 class="text-center mb-4">Sign Up</h2>

    @if ($errors->any())
      <div class="error-box">
        @if(count($errors->all()) > 1)
          <strong>Multiple fields are required or incorrect:</strong>
        @endif
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
      @csrf

      <div class="row">
        <div class="col-md-3 d-flex flex-column align-items-center justify-content-center">
          <img id="profilePreview" src="/storage/images/default.jpg" alt="Profile Image" class="circle-image mb-2">
          <label class="btn-upload">
            Choose image
            <input type="file" name="image" id="image" accept="image/*" hidden onchange="previewImage(event)">
          </label>
        </div>

        <div class="col-md-9">
          <div class="row">
            <div class="col-md-6 mb-3">
              <input type="text" name="name" class="form-control" placeholder="Complete Name" value="{{ old('name') }}">
            </div>
            <div class="col-md-6 mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
            </div>
            <div class="col-md-6 mb-3">
              <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
            </div>
            <div class="col-md-6 mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-center">
              <input type="checkbox" name="is_private" value="1" id="is_private" hidden>
              <label class="toggle-switch">
                <input type="checkbox" onclick="document.getElementById('is_private').checked = this.checked;">
                <span class="slider"></span>
              </label>
              <span class="ms-2">Private account</span>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-3 text-center">
        <p class="text-muted" style="font-size: 0.85rem;">
          People who use our service may have uploaded your contact information to Mango ©. More information. By clicking "Sign up", you agree to our Terms, Privacy Policy and Cookies Policy. We may send you SMS notifications, which you can turn off at any time.
        </p>
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </div>

      <div class="text-center mt-3">
        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
      </div>

      <div class="text-center footer-text mt-2">
        © 2025 Mango
      </div>
    </form>
  </div>
</div>

<script>
  function previewImage(event) {
    const output = document.getElementById('profilePreview');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = () => URL.revokeObjectURL(output.src);
  }
</script>

</body>
</html>
