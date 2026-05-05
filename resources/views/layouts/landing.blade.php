<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pivot Caffe')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #0e6446;
            --primary-light: #16a34a;
            --primary-dark: #0a4f37;
            --secondary: #d7d7d7;
            --text: #1a1a1a;
            --text-light: #6b7280;
            --bg: #f5f5f5;
            --white: #ffffff;
            --border: 1px solid #d7d7d7;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: var(--white);
            border-bottom: var(--border);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 5%;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text);
            font-weight: 700;
            font-size: 20px;
        }

        .navbar-brand img {
            height: 40px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-light);
            font-weight: 500;
            font-size: 15px;
            transition: color 0.2s;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--primary);
        }

        main {
            flex: 1;
            padding-top: 70px;
        }

        footer {
            background: var(--white);
            color: var(--text);
            padding: 40px 5%;
            text-align: center;
            margin-top: auto;
            border-top: var(--border);
        }

        footer p {
            color: var(--text-light);
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            text-align: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: 1px solid var(--primary-dark);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            background: var(--white);
            color: var(--text);
            border: var(--border);
        }

        .btn-outline:hover {
            background: var(--bg);
            color: var(--text);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-title {
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Menu Button */
        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }

        .menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: var(--text);
            border-radius: 3px;
            transition: 0.3s;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }
            .nav-links {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                gap: 0;
                border-bottom: var(--border);
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
                transition: clip-path 0.3s ease-in-out;
            }
            .nav-links.active {
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }
            .nav-links a {
                padding: 15px 5%;
                border-bottom: 1px solid #eee;
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('landing.home') }}" class="navbar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe Logo">
            Pivot Caffe
        </a>
        <button class="menu-toggle" id="mobile-menu-btn" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="nav-links" id="nav-links">
            <a href="{{ route('landing.home') }}" class="{{ request()->routeIs('landing.home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('landing.about') }}" class="{{ request()->routeIs('landing.about') ? 'active' : '' }}">About</a>
            <a href="{{ route('landing.contact') }}" class="{{ request()->routeIs('landing.contact') ? 'active' : '' }}">Contact</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <h3 class="footer-title">Pivot Caffe</h3>
            <p>&copy; {{ date('Y') }} Pivot Caffe. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('nav-links').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
