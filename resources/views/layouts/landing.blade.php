<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pivot Caffe')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #1b4332;
            --primary-light: #2d6a4f;
            --primary-dark: #081c15;
            --accent: #d4a373;
            --accent-light: #faedcd;
            --text: #1a1a1a;
            --text-light: #6b7280;
            --bg: #fdfcfb;
            --white: #ffffff;
            --border: 1px solid rgba(0,0,0,0.1);
            --shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: transparent;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 8%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 12px 8%;
            box-shadow: var(--shadow);
            border-bottom: var(--border);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--white);
            font-weight: 700;
            font-size: 22px;
            transition: color 0.3s;
        }

        .navbar.scrolled .navbar-brand {
            color: var(--primary);
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar.scrolled .navbar-brand img {
            filter: none;
        }

        .nav-links {
            display: flex;
            gap: 40px;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s;
        }

        .nav-links a:hover::after, .nav-links a.active::after {
            width: 100%;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--white);
        }

        .navbar.scrolled .nav-links a {
            color: var(--text-light);
        }

        .navbar.scrolled .nav-links a:hover, .navbar.scrolled .nav-links a.active {
            color: var(--primary);
        }

        main {
            flex: 1;
        }

        footer {
            background: var(--primary-dark);
            color: var(--white);
            padding: 80px 8% 40px;
            border-top: var(--border);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-info p {
            color: rgba(255,255,255,0.6);
            margin-top: 20px;
            max-width: 300px;
        }

        .footer-links h4 {
            font-size: 18px;
            margin-bottom: 25px;
            color: var(--accent);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 12px;
        }

        .footer-links ul li a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links ul li a:hover {
            color: var(--white);
        }

        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }

        .footer-bottom {
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            color: rgba(255,255,255,0.4);
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: none;
            text-align: center;
            font-size: 15px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(27, 67, 50, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(27, 67, 50, 0.4);
        }

        .btn-accent {
            background: var(--accent);
            color: var(--primary-dark);
        }

        .btn-accent:hover {
            background: var(--accent-light);
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
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
            height: 2px;
            background-color: var(--white);
            transition: 0.3s;
        }

        .navbar.scrolled .menu-toggle span {
            background-color: var(--primary);
        }

        @media (max-width: 992px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .navbar { 
                padding: 15px 5%; 
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-bottom: var(--border);
            }
            .navbar-brand { color: var(--primary); }
            .menu-toggle { display: flex; }
            .menu-toggle span { background-color: var(--primary); }
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
                transition: clip-path 0.4s ease-in-out;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .nav-links.active {
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }
            .nav-links a {
                padding: 20px 8%;
                border-bottom: 1px solid #f0f0f0;
                display: block;
                color: var(--text) !important;
                font-size: 16px;
            }
            .nav-links a:last-child { border-bottom: none; }
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .section-title h2 { font-size: 2.2rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar" id="navbar">
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
            <div class="footer-grid">
                <div class="footer-info">
                    <h3 class="font-serif" style="font-size: 24px; color: var(--accent);">Pivot Caffe</h3>
                    <p>Tempat terbaik untuk menikmati kopi pilihan dengan suasana yang hangat dan inspiratif. Kami menghadirkan biji kopi terbaik dari petani lokal untuk Anda.</p>
                    <div class="footer-social">
                        <a href="https://www.instagram.com/pivotco.op/" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="{{ route('landing.home') }}">Home</a></li>
                        <li><a href="{{ route('landing.about') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('landing.contact') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Kontak Kami</h4>
                    <p style="color: rgba(255,255,255,0.6); font-size: 14px;">
                        4F2W+X6 Padang MAS, Kabupaten Karo, Sumatera Utara<br><br>
                        Email: info@pivotcoffee.id<br>
                        Phone: +62 812-3456-7890
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Pivot Caffe. Crafted with passion for coffee lovers.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('nav-links').classList.toggle('active');
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

