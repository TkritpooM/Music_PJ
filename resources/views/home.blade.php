<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Studio Booking</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Music Studio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#promotions">Promotions</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="py-5 text-center bg-light">
        <div class="container">
            <h1 class="display-4">Welcome to Music Studio</h1>
            <p class="lead">Book your rehearsal room now!</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Book Now</a>
        </div>
    </section>

    <!-- Promotions Section -->
    <section id="promotions" class="py-5">
        <div class="container">
            <h2 class="mb-4">Promotions</h2>
            @php
                $promotions = []; // array ว่างชั่วคราว
            @endphp

            @if(empty($promotions))
                <p class="text-muted">No promotions currently.</p>
            @else
                <div class="row">
                    @foreach($promotions as $promo)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $promo->name }}</h5>
                                    <p class="card-text">{{ $promo->discount_value }} {{ $promo->discount_type }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Rooms Grid -->
    <section id="rooms" class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-4">Our Rooms</h2>
            @php
                $rooms = []; // array ว่างชั่วคราว
            @endphp

            @if(empty($rooms))
                <p class="text-muted">No rooms available.</p>
            @else
                <div class="row">
                    @foreach($rooms as $room)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="{{ $room->image_url ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $room->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $room->name }}</h5>
                                    <p class="card-text">Price: {{ $room->price_per_hour }} / hour</p>
                                    <p class="card-text">Capacity: {{ $room->capacity }} people</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary">Book Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white text-center">
        <div class="container">
            <p class="mb-0">Contact us at: info@musicstudio.com</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
