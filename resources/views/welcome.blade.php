<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piff Credits - Secure Freelance Payments in USDT</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts for professional typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Professional color scheme and typography */
        :root {
            --primary-color: #1B263B; /* Deep navy for sophistication */
            --secondary-color: #415A77; /* Muted blue for accents */
            --accent-color: #E0B973; /* Subtle gold for premium feel */
            --background-color: #F5F7FA; /* Clean, light background */
            --text-color: #1F2937; /* Dark gray for readability */
            --muted-color: #6B7280; /* Muted gray for secondary text */
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            background-color: var(--background-color);
        }

        /* Navbar styles */
        .navbar {
            background-color: #FFFFFF;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .nav-link.custom-nav {
            color: var(--text-color);
            font-weight: 500;
            transition: color 0.3s ease, background-color 0.3s ease;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
        }
        .nav-link.custom-nav:hover {
            color: var(--accent-color);
            background-color: rgba(224, 185, 115, 0.1);
        }
        .nav-link.custom-nav:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(224, 185, 115, 0.3);
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        /* Dark mode */
        @media (prefers-color-scheme: dark) {
            :root {
                --background-color: #1F2937;
                --text-color: #E5E7EB;
                --muted-color: #9CA3AF;
            }
            .navbar {
                background-color: #111827 !important;
            }
            .nav-link.custom-nav {
                color: var(--text-color);
            }
            .nav-link.custom-nav:hover {
                color: var(--accent-color);
                background-color: rgba(224, 185, 115, 0.1);
            }
            .nav-link.custom-nav:focus {
                box-shadow: 0 0 0 3px rgba(224, 185, 115, 0.3);
            }
            .navbar-brand, .text-dark {
                color: var(--text-color) !important;
            }
            .hero-section, .features-section {
                background-color: #111827 !important;
            }
            .btn-primary {
                background-color: var(--accent-color);
                border-color: var(--accent-color);
            }
        }

        /* Hero section */
        .hero-section {
            background-color: #FFFFFF;
            padding: 6rem 0;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        .hero-section p {
            font-size: 1.25rem;
            color: var(--muted-color);
            max-width: 600px;
            margin: 0 auto 2rem;
        }
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #D4A65A;
            border-color: #D4A65A;
            transform: translateY(-2px);
        }

        /* Features section */
        .features-section {
            padding: 5rem 0;
            background-color: var(--background-color);
        }
        .features-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        .feature-card {
            background-color: #FFFFFF;
            border-radius: 0.75rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .feature-card h5 {
            color: var(--primary-color);
            font-weight: 600;
        }
        .feature-card p {
            color: var(--muted-color);
            font-size: 1rem;
        }

        /* Footer */
        footer {
            padding: 3rem 0;
            background-color: #FFFFFF;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        footer p {
            color: var(--muted-color);
            font-size: 0.9rem;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .hero-section h1 {
                font-size: 4.5rem;
            }
        }

        /* Desktop vs mobile nav */
        .desktop-nav {
            display: none;
        }
        @media (min-width: 992px) {
            .desktop-nav {
                display: flex;
            }
            .mobile-nav {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header class="shadow">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="Main navigation">
            <div class="container">
                <a class="navbar-brand fw-bold text-dark" href="#">Piff Credits</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    @if (Route::has('login'))
                        <div class="navbar-nav">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="nav-link custom-nav">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="nav-link custom-nav">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="nav-link custom-nav">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <h1 class="text-dark mb-4">Get Paid Seamlessly in USDT</h1>
                <p class="text-muted mb-5">Empower your freelance career with Piff Credits. Receive payments in USDT effortlessly, no matter where you are, bypassing restrictions of traditional payment methods.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">Start Freelancing Now</a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <h2 class="text-center text-dark mb-5 fw-bold">Why Choose Piff Credits?</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Global USDT Payments</h5>
                                <p class="card-text text-muted">Get paid in USDT, bypassing restrictions in countries where traditional payment methods are limited.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Fast and Secure</h5>
                                <p class="card-text text-muted">Enjoy quick, secure transactions with blockchain technology, ensuring your earnings are safe.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Freelancer Freedom</h5>
                                <p class="card-text text-muted">Work with clients worldwide and get paid without worrying about payment gateway restrictions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center py-4">
            <p class="text-muted mb-2">&copy; 2025 Piff Credits. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>