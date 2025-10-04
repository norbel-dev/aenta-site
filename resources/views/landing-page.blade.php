<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aenta</title>
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
            background-color: var(--aenta-section-bg);
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-bottom: 2rem;
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
            padding-bottom: 80px; /* Footer height */
        }
    </style>
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
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container container mt-4">
        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/logo-aenta12.png') }}" class="d-block" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/logo-aenta12.png') }}" class="d-block" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/logo-aenta12.png') }}" class="d-block" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Importante, novedoso</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($novedoso as $item)
                            <li class="list-group-item">{{ $item->title }}</li>
                        @empty
                            <li class="list-group-item">No hay items.</li>
                        @endforelse
                    </ul>
                    @if(isset($novedoso) && $novedoso->count() > 3)
                        <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Noticias</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($noticias as $item)
                            <li class="list-group-item">{{ $item->title }}</li>
                        @empty
                            <li class="list-group-item">No hay noticias.</li>
                        @endforelse
                    </ul>
                    @if(isset($noticias) && $noticias->count() > 3)
                        <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Eventos</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($eventos as $item)
                            <li class="list-group-item">{{ $item->title }}</li>
                        @empty
                            <li class="list-group-item">No hay eventos.</li>
                        @endforelse
                    </ul>
                    @if(isset($eventos) && $eventos->count() > 3)
                    <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Convocatorias</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($convocatorias as $item)
                            <li class="list-group-item">{{ $item->title }}</li>
                        @empty
                            <li class="list-group-item">No hay convocatorias.</li>
                        @endforelse
                    </ul>
                    @if(isset($convocatorias) && $convocatorias->count() > 3)
                        <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Servicios</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($servicios as $item)
                            <li class="list-group-item">{{ $item->name }}</li>
                        @empty
                            <li class="list-group-item">No hay servicios.</li>
                        @endforelse
                    </ul>
                    @if(isset($servicios) && $servicios->count() > 3)
                        <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Productos</h5>
                    <ul class="list-group list-group-flush">
                         <li class="list-group-item">No hay productos.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="section-bar mt-4">
            <h5>Enlaces a Centros del Sistema</h5>
        </div>
    </div>

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
