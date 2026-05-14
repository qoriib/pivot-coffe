<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            --danger: #dc2626;
            --success: #16a34a;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            min-height: 100vh;
        }

        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 25px;
            width: 100%;
        }

        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: transparent;
            z-index: 1000;
            padding: 25px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar.scrolled, .navbar.navbar-solid {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
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

        .navbar.scrolled .navbar-brand, .navbar.navbar-solid .navbar-brand {
            color: var(--primary);
        }

        .navbar-brand img {
            height: 40px;
        }

        .nav-links {
            display: flex;
            gap: 35px;
            align-items: center;
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

        .navbar.scrolled .nav-links a, .navbar.navbar-solid .nav-links a {
            color: var(--text-light);
        }

        .navbar.scrolled .nav-links a:hover, .navbar.scrolled .nav-links a.active,
        .navbar.navbar-solid .nav-links a:hover, .navbar.navbar-solid .nav-links a.active {
            color: var(--primary);
        }

        .nav-meta {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .table-badge {
            background: var(--accent);
            color: var(--primary-dark);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .cart-toggle-btn {
            position: relative;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .navbar.scrolled .cart-toggle-btn, .navbar.navbar-solid .cart-toggle-btn {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 20px;
            cursor: pointer;
            margin-left: 10px;
            transition: color 0.3s;
        }

        .navbar.scrolled .menu-toggle, .navbar.navbar-solid .menu-toggle {
            color: var(--primary);
        }

        .cart-toggle-btn:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: var(--primary-dark);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--white);
        }

        main {
            flex: 1;
        }

        .cart-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .cart-backdrop.open {
            opacity: 1;
            visibility: visible;
        }

        .cart-drawer {
            position: fixed;
            top: 0; right: 0;
            width: 100%; max-width: 450px;
            height: 100vh;
            background: var(--white);
            z-index: 2001;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
        }

        .cart-backdrop.open .cart-drawer {
            transform: translateX(0);
        }

        .cart-header {
            padding: 25px;
            border-bottom: var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-body {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
        }

        .cart-footer {
            padding: 25px;
            background: #fafafa;
            border-top: var(--border);
        }

        /* Toasts */
        #toast-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid var(--primary);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.3s ease-out;
            min-width: 250px;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Footer */
        footer {
            background: var(--primary-dark);
            color: var(--white);
            padding: 100px 8% 60px;
            text-align: center;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .footer-brand {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 25px;
        }

        .footer-description {
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 40px;
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 50px;
        }

        .social-icon {
            width: 50px; height: 50px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: var(--white); text-decoration: none;
            transition: all 0.3s; font-size: 1.2rem;
        }

        .social-icon:hover {
            background: var(--accent); color: var(--primary-dark); transform: translateY(-5px);
        }

        /* Utility Classes */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer; border: none; text-align: center; font-size: 15px;
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

        .btn-primary { background: var(--primary); color: white; }
        .btn-accent { background: var(--accent); color: var(--primary-dark); }
        .btn-block { width: 100%; display: block; }
        .btn-sm { padding: 8px 20px; font-size: 13px; }

        .bg-light { background-color: #f8f9fa; }
        .bg-white { background-color: #ffffff; }
        .text-center { text-align: center; }
        
        .no-print { @media print { display: none !important; } }
        
        /* Display Utilities */
        .d-none { display: none !important; }
        .d-block { display: block !important; }
        .d-flex { display: flex !important; }
        .d-grid { display: grid !important; }

        @media (min-width: 992px) {
            .d-lg-none { display: none !important; }
            .d-lg-block { display: block !important; }
            .d-lg-flex { display: flex !important; }
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Cart Item Row */
        .cart-item-row {
            display: flex; align-items: center; gap: 15px; padding: 15px 0;
            border-bottom: 1px dashed rgba(0,0,0,0.1);
        }
        
        .cart-item-info { flex: 1; }
        .cart-item-name { font-weight: 700; font-size: 14px; margin-bottom: 2px; }
        .cart-item-price { font-size: 12px; color: var(--text-light); }
        .cart-qty-ctrl { display: flex; align-items: center; gap: 10px; }
        .cart-qty-btn { 
            width: 26px; height: 26px; border-radius: 6px; border: var(--border); 
            background: white; cursor: pointer; display: flex; align-items: center; justify-content: center;
            font-size: 14px;
        }
        .cart-qty-num { font-weight: 700; font-size: 14px; min-width: 20px; text-align: center; }

        /* Floating Order Status */
        .floating-order-status {
            position: fixed;
            right: 18px;
            bottom: 22px;
            z-index: 2500;
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            border: var(--border);
            box-shadow: var(--shadow);
            border-radius: 10px;
            padding: 10px 14px;
            text-decoration: none;
            color: var(--text);
            min-width: 220px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .floating-order-status:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(0,0,0,0.12);
        }

        .floating-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.18);
        }

        .floating-status-dot.processing {
            background: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.18);
        }

        .floating-status-dot.success {
            background: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.18);
        }

        .floating-status-dot.danger {
            background: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.18);
        }

        .floating-status-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .floating-status-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-light);
        }

        .floating-status-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
        }

        .floating-status-meta {
            font-size: 11px;
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .navbar { padding: 15px 0; background: rgba(255, 255, 255, 0.95); border-bottom: var(--border); }
            .navbar-brand { color: var(--primary); }
            
            .menu-toggle { display: block; color: var(--primary); }
            .cart-toggle-btn { 
                background: var(--primary); 
                border-color: var(--primary); 
                color: white; 
            }
            .cart-badge { border-color: var(--white); }

            .nav-links {
                position: absolute; top: 100%; left: 0; right: 0; background: white;
                flex-direction: column; gap: 0; border-bottom: var(--border);
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); transition: clip-path 0.4s ease-in-out;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .nav-links.active { clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); }
            .nav-links a { padding: 20px 25px; border-bottom: 1px solid #f0f0f0; display: block; color: var(--text) !important; }
            .nav-meta { margin-left: auto; }
        }
    </style>
    @stack('styles')
</head>
@php
    $cart = [];
    $cartCount = 0;
    $cartTotal = 0;
    if(session('table_id')) {
        $cart = session('cart_' . session('table_id'), []);
        $cartCount = collect($cart)->sum('quantity');
        $cartTotal = collect($cart)->sum(fn($item) => $item['quantity'] * $item['unit_price']);
    }
@endphp
<body>

    <nav class="navbar {{ !request()->routeIs('customer.home', 'customer.about', 'customer.contact') ? 'navbar-solid' : '' }}" id="navbar">
        <div class="container navbar-container">
            <a href="{{ session('table_id') ? route('customer.home', session('table_id')) : url('/') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe Logo">
                Pivot Caffe
            </a>
            
            <div class="nav-links" id="nav-links">
                <a href="{{ session('table_id') ? route('customer.home', session('table_id')) : url('/') }}" class="{{ request()->routeIs('customer.home') ? 'active' : '' }}">Home</a>
                @if(session('qr_token'))
                    <a href="{{ route('customer.menu', session('qr_token')) }}" class="{{ request()->routeIs('customer.menu*') ? 'active' : '' }}">Pesan</a>
                @endif
                <a href="{{ route('customer.about') }}" class="{{ request()->routeIs('customer.about') ? 'active' : '' }}">About</a>
                <a href="{{ route('customer.contact') }}" class="{{ request()->routeIs('customer.contact') ? 'active' : '' }}">Contact</a>
            </div>

            <div class="nav-meta">
                @if(session('table_number'))
                    <div class="table-badge">Meja {{ session('table_number') }}</div>
                @endif

                @if(session('table_id'))
                    <button class="cart-toggle-btn" onclick="toggleCart()" id="cart-icon-btn">
                        <i class="fas fa-shopping-basket"></i>
                        @if($cartCount > 0)
                            <span class="cart-badge" id="cart-badge-count">{{ $cartCount }}</span>
                        @endif
                    </button>
                @endif

                <button class="menu-toggle" id="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="cart-backdrop" id="cart-backdrop" onclick="handleBackdropClick(event)">
        <div class="cart-drawer" id="cart-drawer">
            <div class="cart-header">
                <h3 class="font-serif">Pesanan Anda</h3>
                <button class="cart-qty-btn" onclick="toggleCart()"><i class="fas fa-times"></i></button>
            </div>
            <div class="cart-body" id="cart-drawer-body">
                @forelse($cart as $id => $item)
                    <div class="cart-item-row">
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item['name'] }}</div>
                            <div class="cart-item-price">Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</div>
                        </div>
                        <div class="cart-qty-ctrl">
                            <form action="{{ route('customer.cart.update', session('qr_token')) }}" method="POST" style="display:inline">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $id }}">
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                <button type="submit" class="cart-qty-btn" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}><i class="fas fa-minus"></i></button>
                            </form>
                            <span class="cart-qty-num">{{ $item['quantity'] }}</span>
                            <form action="{{ route('customer.cart.update', session('qr_token')) }}" method="POST" style="display:inline">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $id }}">
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                <button type="submit" class="cart-qty-btn"><i class="fas fa-plus"></i></button>
                            </form>
                            <form action="{{ route('customer.cart.remove', session('qr_token')) }}" method="POST" style="display:inline; margin-left: 10px;">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $id }}">
                                <button type="submit" class="cart-qty-btn" style="color: var(--danger); border-color: rgba(220, 38, 38, 0.2);"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="text-align:center; color: var(--text-light); margin-top: 50px;">Keranjang kosong</p>
                @endforelse
            </div>
            @if($cartCount > 0)
            <div class="cart-footer" id="cart-drawer-footer">
                <div style="display:flex; justify-content:space-between; margin-bottom: 15px;">
                    <span style="font-weight: 500;">Subtotal</span>
                    <span id="cart-subtotal-display" style="font-weight: 700; color: var(--primary);">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
                <a id="cart-checkout-btn" href="{{ route('customer.checkout', session('qr_token')) }}" class="btn btn-primary btn-block">Checkout Sekarang</a>
                <form id="cart-clear-form" action="{{ route('customer.cart.clear', session('qr_token')) }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" class="btn btn-block" style="background:none; color: var(--text-light); font-size: 13px;" onclick="return confirm('Kosongkan keranjang?')">Kosongkan Keranjang</button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    @if(session('last_transaction_id'))
    <a
        href="{{ route('customer.status', session('last_transaction_id')) }}"
        class="floating-order-status"
        id="floating-order-status"
        data-status-url="{{ route('customer.status.peek', session('last_transaction_id')) }}"
        aria-live="polite"
    >
        <span class="floating-status-dot" id="floating-status-dot"></span>
        <span class="floating-status-text">
            <span class="floating-status-title">Status Pesanan</span>
            <span class="floating-status-value" id="floating-status-value">Memuat...</span>
            <span class="floating-status-meta" id="floating-status-meta">Klik untuk detail</span>
        </span>
    </a>
    @endif

    <div id="toast-container"></div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <h3 class="footer-brand font-serif">Pivot Caffe</h3>
                <p class="footer-description">
                    Tempat terbaik untuk menikmati kopi pilihan dengan suasana yang hangat dan inspiratif. Kami menghadirkan biji kopi terbaik dari petani lokal untuk Anda.
                </p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/pivotco.op/" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Pivot Caffe. Crafted with passion for coffee lovers.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('nav-links').classList.toggle('active');
        });

        // Cart Drawer Functions
        function toggleCart() {
            const bd = document.getElementById('cart-backdrop');
            bd.classList.toggle('open');
            document.body.style.overflow = bd.classList.contains('open') ? 'hidden' : '';
        }
        function handleBackdropClick(e) {
            if (e.target === document.getElementById('cart-backdrop')) toggleCart();
        }

        // Toast Notification
        function cToast(msg, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.style.borderLeft = `5px solid ${type === 'success' ? 'var(--success)' : 'var(--danger)'}`;
            toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}" style="color: ${type === 'success' ? 'var(--success)' : 'var(--danger)'}"></i> <span>${msg}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0'; toast.style.transform = 'translateX(20px)';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        @if(session('success')) cToast(@json(session('success')), 'success'); @endif
        @if(session('error')) cToast(@json(session('error')), 'error'); @endif
        @if(session('waiter_called')) cToast(@json(session('waiter_called')), 'success'); @endif

        // Floating order status polling
        (function () {
            var widget = document.getElementById('floating-order-status');
            if (!widget) return;

            var url = widget.getAttribute('data-status-url');
            var dot = document.getElementById('floating-status-dot');
            var valueEl = document.getElementById('floating-status-value');
            var metaEl = document.getElementById('floating-status-meta');

            function statusLabel(status) {
                if (status === 'menunggu') return 'Menunggu Konfirmasi';
                if (status === 'diproses') return 'Sedang Diproses';
                if (status === 'selesai') return 'Selesai';
                if (status === 'dibatalkan') return 'Dibatalkan';
                return 'Status Tidak Diketahui';
            }

            function dotClass(status) {
                if (status === 'diproses') return 'processing';
                if (status === 'selesai') return 'success';
                if (status === 'dibatalkan') return 'danger';
                return '';
            }

            function updateWidget(data) {
                var label = statusLabel(data.order_status);
                valueEl.textContent = label;
                metaEl.textContent = 'Meja ' + data.table_number + ' • ' + data.transaction_id;
                dot.className = 'floating-status-dot ' + dotClass(data.order_status);

                if (data.order_status === 'selesai' || data.order_status === 'dibatalkan') {
                    clearInterval(window.__orderStatusInterval);
                }
            }

            function fetchStatus() {
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (res) { return res.ok ? res.json() : null; })
                    .then(function (data) {
                        if (!data) return;
                        updateWidget(data);
                    })
                    .catch(function () {
                        valueEl.textContent = 'Status tidak tersedia';
                    });
            }

            fetchStatus();
            window.__orderStatusInterval = setInterval(fetchStatus, 5000);
        })();
    </script>
    @stack('scripts')
</body>
</html>
