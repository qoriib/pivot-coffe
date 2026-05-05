<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pivot Caffe')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #0e6446;
            --primary-dark: #0a4f37;
            --secondary: #d7d7d7;
            --text: #1a1a1a;
            --text-muted: #6b7280;
            --bg: #f0f2f0;
            --white: #ffffff;
            --danger: #dc2626;
            --success: #16a34a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ══ TOPBAR ══════════════════════════════════════════════ */
        .topbar {
            background: var(--primary);
            color: var(--white);
            padding: 0 20px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 300;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .topbar-left { display: flex; align-items: center; gap: 10px; }
        .topbar-brand { font-size: 17px; font-weight: 700; letter-spacing: -0.3px; }
        .topbar-table {
            font-size: 11px;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            padding: 3px 10px;
            font-weight: 500;
        }

        .topbar-right { display: flex; align-items: center; gap: 8px; }

        /* Keranjang icon button */
        .cart-icon-btn {
            position: relative;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 8px;
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: white;
            transition: background 0.15s;
            flex-shrink: 0;
        }
        .cart-icon-btn:hover { background: rgba(255,255,255,0.28); }
        .cart-icon-btn svg { width: 20px; height: 20px; }
        .cart-badge {
            position: absolute; top: -6px; right: -6px;
            background: #ef4444; color: white;
            border-radius: 50%; width: 18px; height: 18px;
            font-size: 10px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--primary);
            line-height: 1;
        }

        /* Waiter button — fixed pojok kanan bawah */
        .waiter-fab {
            position: fixed;
            bottom: 24px; right: 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px; font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(14,100,70,0.35);
            z-index: 200;
            transition: transform 0.15s, box-shadow 0.15s;
            white-space: nowrap;
        }
        .waiter-fab:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(14,100,70,0.4); }
        .waiter-fab:active { transform: scale(0.97); }

        /* ══ PAGE WRAPPER — RESPONSIVE ═══════════════════════════ */
        /* Mobile: full width single column                         */
        /* Desktop (≥900px): centered, wider, 2-col layout         */
        .page-wrapper {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px 16px 100px;
        }

        @media (min-width: 640px) {
            .page-wrapper { padding: 24px 24px 80px; }
        }

        @media (min-width: 900px) {
            .page-wrapper { padding: 28px 40px 60px; }
        }

        /* ══ ALERTS ══════════════════════════════════════════════ */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-info    { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

        /* ══ BUTTONS ═════════════════════════════════════════════ */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            padding: 10px 20px; border-radius: 8px;
            font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
            cursor: pointer; border: none; text-decoration: none; transition: opacity 0.15s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary  { background: var(--primary); color: var(--white); }
        .btn-secondary{ background: var(--secondary); color: var(--text); }
        .btn-danger   { background: var(--danger); color: var(--white); }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-block { width: 100%; }

        /* ══ CARDS ═══════════════════════════════════════════════ */
        .card { background: var(--white); border-radius: 12px; border: 1px solid var(--secondary); overflow: hidden; margin-bottom: 16px; }
        .card-body { padding: 16px; }

        /* ══ FORMS ═══════════════════════════════════════════════ */
        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 5px; }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%; padding: 10px 12px;
            border: 1px solid var(--secondary); border-radius: 8px;
            font-family: 'Poppins', sans-serif; font-size: 14px;
            color: var(--text); background: var(--white);
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--primary); }
        .field-error { color: var(--danger); font-size: 12px; margin-top: 4px; }

        /* ══ BADGES ══════════════════════════════════════════════ */
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-success  { background: #dcfce7; color: #166534; }
        .badge-warning  { background: #fef3c7; color: #92400e; }
        .badge-danger   { background: #fee2e2; color: #991b1b; }
        .badge-secondary{ background: var(--secondary); color: var(--text-muted); }

        /* ══ SECTION TITLE ═══════════════════════════════════════ */
        .section-title { font-size: 15px; font-weight: 700; margin-bottom: 12px; color: var(--text); }

        /* ══ CART DRAWER (popup dari kanan) ══════════════════════ */
        .cart-backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 400;
            opacity: 0; visibility: hidden;
            transition: opacity 0.25s, visibility 0.25s;
        }
        .cart-backdrop.open { opacity: 1; visibility: visible; }

        .cart-drawer {
            position: fixed;
            top: 0; right: 0;
            width: 100%; max-width: 400px;
            height: 100vh;
            background: var(--white);
            z-index: 401;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            box-shadow: -4px 0 32px rgba(0,0,0,0.15);
        }
        .cart-backdrop.open .cart-drawer { transform: translateX(0); }

        .cart-drawer-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--secondary);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
            background: var(--white);
        }
        .cart-drawer-title { font-size: 16px; font-weight: 700; }
        .cart-drawer-close {
            width: 32px; height: 32px; border-radius: 8px;
            border: none; background: var(--secondary);
            cursor: pointer; font-size: 18px; color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
        }
        .cart-drawer-close:hover { background: #c8c8c8; }

        .cart-drawer-body { flex: 1; overflow-y: auto; padding: 12px 20px; }

        .cart-drawer-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--secondary);
            background: #fafafa;
            flex-shrink: 0;
        }

        .cart-item-row {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 0; border-bottom: 1px solid #f0f0f0;
        }
        .cart-item-row:last-child { border-bottom: none; }
        .cart-item-info { flex: 1; min-width: 0; }
        .cart-item-name { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cart-item-price { font-size: 11px; color: var(--text-muted); }
        .cart-item-subtotal { font-size: 13px; font-weight: 700; color: var(--primary); white-space: nowrap; }

        .cart-qty-ctrl { display: flex; align-items: center; gap: 5px; flex-shrink: 0; }
        .cart-qty-btn {
            width: 26px; height: 26px; border-radius: 6px;
            border: 1px solid var(--secondary); background: white;
            font-size: 14px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }
        .cart-qty-num { font-size: 13px; font-weight: 600; min-width: 22px; text-align: center; }

        /* ══ TOAST ═══════════════════════════════════════════════ */
        #c-toast-wrap {
            position: fixed; top: 68px; left: 50%;
            transform: translateX(-50%);
            z-index: 500; pointer-events: none;
            width: calc(100% - 32px); max-width: 380px;
            display: flex; flex-direction: column; gap: 8px;
        }
        .c-toast {
            background: white; border-radius: 10px;
            padding: 12px 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 10px;
            pointer-events: all;
            animation: cToastIn 0.3s cubic-bezier(0.34,1.56,0.64,1);
        }
        .c-toast-success { border-left: 4px solid var(--success); color: #166534; }
        .c-toast-error   { border-left: 4px solid var(--danger);  color: #991b1b; }
        .c-toast-info    { border-left: 4px solid #3b82f6;        color: #1e40af; }
        @keyframes cToastIn  { from { opacity:0; transform:translateY(-12px) scale(0.95); } to { opacity:1; transform:translateY(0) scale(1); } }
        @keyframes cToastOut { from { opacity:1; transform:translateY(0) scale(1); } to { opacity:0; transform:translateY(-12px) scale(0.95); } }

        /* ══ ALERT AUTO-DISMISS ══════════════════════════════════ */
        @keyframes alertFadeOut {
            0%   { opacity: 1; max-height: 80px; margin-bottom: 16px; padding: 12px 16px; }
            70%  { opacity: 0; max-height: 80px; }
            100% { opacity: 0; max-height: 0; margin-bottom: 0; padding: 0; }
        }
        .alert.dismissing {
            animation: alertFadeOut 0.5s ease forwards;
            overflow: hidden;
        }

        @media print { .no-print { display: none !important; } }
    </style>
    @stack('styles')
</head>
<body>

{{-- ══ TOPBAR ══════════════════════════════════════════════════════════ --}}
<header class="topbar no-print">
    <div class="topbar-left">
        <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe"
             style="height:38px;width:38px;object-fit:contain">
        @if(session('table_number'))
            <div class="topbar-table">Meja {{ session('table_number') }}</div>
        @endif
    </div>
    <div class="topbar-right">
        @if(session('table_id'))
        <button class="cart-icon-btn" onclick="toggleCart()" id="cart-icon-btn" title="Keranjang">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            <span class="cart-badge" id="cart-badge-count" style="display:none">0</span>
        </button>
        @endif
    </div>
</header>

{{-- ══ CART DRAWER ══════════════════════════════════════════════════════ --}}
<div class="cart-backdrop no-print" id="cart-backdrop" onclick="handleBackdropClick(event)">
    <div class="cart-drawer" id="cart-drawer">
        <div class="cart-drawer-header">
            <div class="cart-drawer-title">Keranjang</div>
            <button class="cart-drawer-close" onclick="toggleCart()">×</button>
        </div>
        <div class="cart-drawer-body" id="cart-drawer-body">
            <div style="text-align:center;padding:48px 0;color:#6b7280;font-size:13px">
                Keranjang masih kosong
            </div>
        </div>
        <div class="cart-drawer-footer" id="cart-drawer-footer" style="display:none">
            <div style="margin-bottom:14px">
                <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px">
                    <span style="color:#6b7280">Subtotal</span>
                    <span id="cart-subtotal-display">Rp 0</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:15px;font-weight:700;border-top:1px solid #e5e7eb;padding-top:10px;margin-top:6px">
                    <span>Total</span>
                    <span id="cart-total-display" style="color:var(--primary)">Rp 0</span>
                </div>
            </div>
            <a id="cart-checkout-btn" href="#" class="btn btn-primary btn-block" style="margin-bottom:8px">
                Lanjut ke Checkout
            </a>
            <form id="cart-clear-form" action="#" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary btn-block btn-sm"
                    onclick="return confirm('Kosongkan keranjang?')">Kosongkan Keranjang</button>
            </form>
        </div>
    </div>
</div>

{{-- ══ PAGE CONTENT ═════════════════════════════════════════════════════ --}}
<div class="page-wrapper">
    @if(session('success'))
        <div class="alert alert-success auto-dismiss">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error auto-dismiss">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info auto-dismiss">{{ session('info') }}</div>
    @endif

    @yield('content')
</div>

{{-- ══ TOAST CONTAINER ══════════════════════════════════════════════════ --}}
<div id="c-toast-wrap"></div>

<script>
/* ── Cart drawer ─────────────────────────────────────────────────── */
function toggleCart() {
    const bd = document.getElementById('cart-backdrop');
    bd.classList.toggle('open');
    document.body.style.overflow = bd.classList.contains('open') ? 'hidden' : '';
}
function handleBackdropClick(e) {
    if (e.target === document.getElementById('cart-backdrop')) toggleCart();
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        const bd = document.getElementById('cart-backdrop');
        if (bd && bd.classList.contains('open')) toggleCart();
    }
});

/* ── Toast ───────────────────────────────────────────────────────── */
function cToast(msg, type = 'success') {
    const wrap = document.getElementById('c-toast-wrap');
    const el = document.createElement('div');
    el.className = `c-toast c-toast-${type}`;
    el.textContent = msg;
    wrap.appendChild(el);
    setTimeout(() => {
        el.style.animation = 'cToastOut 0.3s ease forwards';
        setTimeout(() => el.remove(), 300);
    }, 3500);
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('waiter_called'))
        cToast(@json(session('waiter_called')), 'success');
    @endif

    // Auto-dismiss alerts setelah 5 detik
    document.querySelectorAll('.alert.auto-dismiss').forEach(function(el) {
        setTimeout(function() {
            el.classList.add('dismissing');
            setTimeout(function() { el.remove(); }, 500);
        }, 5000);
    });
});
</script>

@stack('scripts')
</body>
</html>
