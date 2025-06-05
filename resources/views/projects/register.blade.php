<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | Mango</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 40px;
    }

    .logo {
      display: block;
      margin: 0 auto 10px;
      width: 40px;
    }

    .circle {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background-color: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      margin: 0 auto 10px;
      border: 2px solid #ccc;
    }

    .circle img {
      width: 100%;
      height: auto;
      object-fit: cover;
    }

    .form-control, .btn {
      border-radius: 10px;
    }

    .toggle-switch {
      position: relative;
      width: 42px;
      height: 24px;
      display: inline-block;
    }

    .toggle-switch input {
      display: none;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      background-color: #ccc;
      border-radius: 34px;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      transition: 0.4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #007bff;
    }

    input:checked + .slider:before {
      transform: translateX(18px);
    }

    .register-card {
      max-width: 1000px;
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      margin: auto;
    }

    .btn-primary {
      font-weight: bold;
      padding: 10px 25px;
    }

    .copyright {
      margin-top: 20px;
      font-size: 14px;
      color: gray;
      text-align: center;
    }

    .choose-btn {
      background-color: #007bff;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
    }

    .choose-btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="register-card">
    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <img src="/storage/images/logo.png" alt="Logo" class="logo">
      <h2 class="text-center mb-4">Sign Up</h2>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="row">
        <div class="col-md-3 d-flex flex-column align-items-center">
          <label for="image" class="form-label">Profile Image</label>
          <div class="circle">
            <img id="profilePreview" src="{{ asset('storage/images/default.jpg') }}" alt="Default Image">
          </div>
          <input type="file" id="image" name="image" class="d-none" onchange="previewImage(event)">
          <label for="image" class="choose-btn mt-1">Choose image</label>
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
              <label class="me-2">Private account</label>
              <label class="toggle-switch">
                <input type="checkbox" name="is_private" value="1">
                <span class="slider"></span>
              </label>
            </div>
          </div>
        </div>
      </div>

      <p class="text-muted mt-3" style="font-size: 0.875rem;">
        People who use our service may have uploaded your contact information to Mango ©. More information. By clicking "Sign up", you agree to our Terms, Privacy Policy and Cookies Policy. We may send you SMS notifications, which you can turn off at any time.
      </p>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </div>

      <p class="text-center mt-3">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
      </p>

      <div class="copyright">© 2025 Mango</div>
    </form>
  </div>
</div>

<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
      const output = document.getElementById('profilePreview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>

</body>
</html>
