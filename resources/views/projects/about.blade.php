<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>About Us</title>
    <!-- Bootstrap CSS y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #dee2e6;
        }
        .btn-wide {
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">About Us</a>
            <div class="ms-auto">
                <a href="{{ url('/') }}" class="btn btn-outline-light">Ir al Inicio</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Menú lateral izquierdo -->
            <div class="col-md-2 bg-light text-start ps-2">
                <div class="left-side-buttons">
                    <nav class="nav flex-column py-4">
                        <img src="{{ asset(Auth::user()->image ?? 'storage/images/default.jpg') }}" class="rounded-circle mb-4 mx-auto d-block" width="80" height="80">
                        <a class="nav-link mb-3 mt-3" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i> Home</a>
                        <a class="nav-link mb-3" href="#"><i class="bi bi-search me-2"></i> Search</a>
                        <a class="nav-link mb-3" href="#"><i class="bi bi-bell me-2"></i> Notifications</a>
                        <a class="nav-link mb-3" href="#"><i class="bi bi-chat-left-text me-2"></i> Messages</a>
                        <a class="nav-link mb-5" href="#"><i class="bi bi-info-circle me-2"></i> About us</a>
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

            <!-- Contenido principal -->
            <div class="col-md-10">
                {{-- Our History Section --}}
                <section class="my-5">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="fw-bold mb-4">Our History</h2>
                            <p class="lead">
                                We are a group of talented engineers who, after several days of brainstorming, debating, and discussing what we were going to do, came up with the great idea of ​​creating this incredible, glamorous project in Laravel. Just looking at it, it deserves a big 100, since not even the best developers could reach this level of computing complexity to come up with this incredible project.
                            </p>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('storage/images/Profe.jpg') }}" alt="Ponga 100 profe" class="img-fluid rounded shadow">
                        </div>
                    </div>
                </section>

                {{-- Group Members Section --}}
                <section class="text-center my-5">
                    <h2 class="fw-bold">Group Members</h2>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-4 mb-5">
                            <h4>Roberto Falquez</h4>
                            <a href="https://github.com/rfalquezg" target="_blank" class="btn btn-dark mt-2">GitHub Account</a>
                            <div class="mt-3">
                                <img src="{{ asset('storage/images/yo.jpeg') }}" alt="Roberto" class="profile-img">
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h4>Fabián Rodas</h4>
                            <a href="https://github.com/Fabianrodas" target="_blank" class="btn btn-dark mt-2">GitHub Account</a>
                            <div class="mt-3">
                                <img src="{{ asset('storage/images/Fabian.png') }}" alt="Fabián" class="profile-img">
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h4>Paula Benalcázar</h4>
                            <a href="https://github.com/paulabenalcazart" target="_blank" class="btn btn-dark mt-2">GitHub Account</a>
                            <div class="mt-3">
                                <img src="{{ asset('storage/images/Paula.jpg') }}" alt="Paula" class="profile-img">
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
