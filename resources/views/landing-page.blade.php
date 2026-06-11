<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AENTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --aenta-blue: #003366;
            --aenta-light-blue: #0099CC;
            --aenta-green: #66CC33;
            --aenta-grey: #f0f2f5;
            --aenta-dark-grey: #333333;
            --aenta-card-bg: #e9ecef;
            --aenta-section-bg: #343a40;
        }
        body {
            font-family: sans-serif;
            background-color: #ffffff;
        }
        .navbar {
            background-color: var(--aenta-light-blue);
            padding: 0.5rem 1rem;
        }
        .navbar-brand img {
            max-height: 40px;
        }
        .nav-link {
            color: white;
            font-weight: bold;
        }
        .nav-link:hover {
            color: var(--aenta-blue);
        }
        .section-bar {
            background-color: var(--aenta-card-bg);
            /* color: white; */
            text-align: center;
            padding: 1rem 0;
            /* margin-bottom: 2rem; */
        }
        .section-bar-link {
            /* background-color: var(--aenta-section-bg); */
            color: rgb(29, 28, 28);
            /* text-align: center; */
            /* margin-bottom: 2rem; */
        }
        .section-bar-link img {
            max-height: 40px;
            max-width: 40px;
        }
        .card-link{
            text-decoration: none;
        }
        .carousel-item img {
            max-height: 250px;
            width: 100%;
        }
        .content-card {
            background-color: var(--aenta-card-bg);
            border: none;
            height: 100%;
            padding: 1.5rem;
            text-align: center;
        }
        .content-card .card-title {
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .content-card .list-group-item {
            background-color: transparent;
            border: none;
            padding: 0.25rem 0;
        }
        .backlink{
            margin-left: 10%;
        }
        .footer {
            background-color: var(--aenta-light-blue);
            color: white;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.9rem;
        }
        .main-container {
            padding-bottom: 50px; /* Footer height */
        }
    </style>
    @yield('css')
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo-aenta12.png') }}" alt="Aenta Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contáctanos</a>
                    </li>
                    <li class="nav-item">
                        @if (Illuminate\Support\Facades\Auth::id())
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        @yield('content')



    <footer class="footer">
        <div class="container d-flex justify-content-between">
            <span>10/03/2025</span>
            <span>Footer</span>
            <span></span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
