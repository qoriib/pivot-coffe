<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Pivot Caffe</title>
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
            --bg: #f5f5f5;
            --white: #ffffff;
            --danger: #dc2626;
            --warning: #d97706;
            --success: #16a34a;
            --sidebar-w: 240px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
        }

        /* ── Sidebar ─────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: var(--primary); color: var(--white);
            display: flex; flex-direction: column;
            z-index: 100; overflow-y: auto;
        }
        .sidebar-brand { padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,0.15); }
        .sidebar-brand h1 { font-size: 18px; font-weight: 700; color: var(--white); }
        .sidebar-brand span { font-size: 11px; opacity: 0.7; font-weight: 400; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .nav-section { padding: 8px 16px 4px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; opacity: 0.5; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: rgba(255,255,255,0.85); text-decoration: none; font-size: 13.5px; font-weight: 400; transition: background 0.15s, color 0.15s; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.12); color: var(--white); }
        .nav-link.active { font-weight: 600; border-left: 3px solid var(--white); }
        .nav-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.5); flex-shrink: 0; }
        .nav-link.active .nav-dot { background: var(--white); }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.15); font-size: 12px; opacity: 0.7; }
        .logout-form { display: inline; }
        .logout-btn { background: none; border: none; color: rgba(255,255,255,0.85); font-family: 'Poppins', sans-serif; font-size: 13.5px; cursor: pointer; padding: 10px 20px; width: 100%; text-align: left; display: flex; align-items: center; gap: 10px; }
        .logout-btn:hover { background: rgba(255,255,255,0.12); color: white; }
        .waiter-badge { background: var(--danger); color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; }

        /* ── Main layout ─────────────────────────── */
        .main-wrapper { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: var(--white); border-bottom: 1px solid var(--secondary); padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 16px; font-weight: 600; }
        .admin-name { font-size: 13px; color: var(--text-muted); }
        .content { flex: 1; padding: 24px; }

        /* ── Cards ───────────────────────────────── */
        .card { background: var(--white); border: 1px solid var(--secondary); border-radius: 8px; overflow: hidden; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--secondary); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 15px; font-weight: 600; }
        .card-body { padding: 20px; }

        /* ── Buttons ─────────────────────────────── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: opacity 0.15s, transform 0.1s; }
        .btn:hover { opacity: 0.85; }
        .btn:active { transform: scale(0.97); }
        .btn-primary { background: var(--primary); color: var(--white); }
        .btn-secondary { background: var(--secondary); color: var(--text); }
        .btn-danger { background: var(--danger); color: var(--white); }
        .btn-warning { background: var(--warning); color: var(--white); }
        .btn-success { background: var(--success); color: var(--white); }
        .btn-sm { padding: 5px 10px; font-size: 12px; }

        /* ── Tables ──────────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px 14px; text-align: left; border-bottom: 1px solid var(--secondary); font-size: 13px; }
        th {
            font-weight: 600; background: #f9f9f9; color: var(--text-muted);
            font-size: 12px; text-transform: uppercase; letter-spacing: 0.04em;
        }
        th:not(.no-sort):hover { background: #f0f0f0; color: var(--text); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        /* ── Forms ───────────────────────────────── */
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 5px; color: var(--text); }
        input[type="text"], input[type="email"], input[type="password"],
        input[type="number"], input[type="date"], input[type="file"],
        select, textarea {
            width: 100%; padding: 9px 12px; border: 1px solid var(--secondary);
            border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 13px;
            color: var(--text); background: var(--white); transition: border-color 0.15s;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--primary); }
        .field-error { color: var(--danger); font-size: 12px; margin-top: 4px; }

        /* ── Badges ──────────────────────────────── */
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-success  { background: #dcfce7; color: #166534; }
        .badge-warning  { background: #fef3c7; color: #92400e; }
        .badge-danger   { background: #fee2e2; color: #991b1b; }
        .badge-info     { background: #dbeafe; color: #1e40af; }
        .badge-secondary{ background: var(--secondary); color: var(--text-muted); }

        /* ── Stat cards ──────────────────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: var(--white); border: 1px solid var(--secondary); border-radius: 8px; padding: 20px; }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.04em; }
        .stat-value { font-size: 32px; font-weight: 700; color: var(--primary); line-height: 1.2; margin-top: 4px; }

        /* ── Pagination ──────────────────────────── */
        .pagination { display: flex; gap: 4px; align-items: center; padding: 16px 20px; border-top: 1px solid var(--secondary); flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 6px 10px; border-radius: 4px; font-size: 13px; text-decoration: none; color: var(--text); border: 1px solid var(--secondary); }
        .pagination .active span { background: var(--primary); color: var(--white); border-color: var(--primary); }

        /* ── Responsive — hamburger mobile ──────────── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }
        .sidebar-overlay.show { display: block; }

        .hamburger {
            display: none;
            background: none; border: none; cursor: pointer;
            padding: 6px; border-radius: 6px;
            flex-direction: column; gap: 5px;
            margin-right: 12px;
        }
        .hamburger span {
            display: block; width: 22px; height: 2px;
            background: var(--text); border-radius: 2px;
            transition: all 0.25s;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
                z-index: 200;
            }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .hamburger { display: flex; }
            .content { padding: 16px; }
        }

        /* ════════════════════════════════════════════
           MODAL SYSTEM
        ════════════════════════════════════════════ */
        .modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 900;
            display: flex; align-items: center; justify-content: center;
            padding: 16px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }
        .modal-backdrop.open {
            opacity: 1;
            visibility: visible;
        }
        .modal {
            background: var(--white);
            border-radius: 12px;
            width: 100%;
            max-width: 540px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            transform: translateY(24px) scale(0.97);
            transition: transform 0.25s ease;
        }
        .modal-backdrop.open .modal {
            transform: translateY(0) scale(1);
        }
        .modal-sm { max-width: 400px; }
        .modal-lg { max-width: 680px; }
        .modal-header {
            padding: 18px 20px 14px;
            border-bottom: 1px solid var(--secondary);
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; background: var(--white); z-index: 1;
            border-radius: 12px 12px 0 0;
        }
        .modal-title { font-size: 15px; font-weight: 700; }
        .modal-close {
            width: 30px; height: 30px; border-radius: 6px;
            border: none; background: var(--secondary);
            cursor: pointer; font-size: 16px; color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s;
        }
        .modal-close:hover { background: #c8c8c8; }
        .modal-body { padding: 20px; }
        .modal-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--secondary);
            display: flex; gap: 10px; justify-content: flex-end;
            background: #fafafa;
            border-radius: 0 0 12px 12px;
        }

        /* ════════════════════════════════════════════
           DELETE CONFIRM MODAL
        ════════════════════════════════════════════ */
        .delete-modal-icon {
            width: 56px; height: 56px; border-radius: 50%;
            background: #fee2e2;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            font-size: 24px;
        }
        .delete-modal-title {
            text-align: center; font-size: 17px; font-weight: 700; margin-bottom: 6px;
        }
        .delete-modal-desc {
            text-align: center; font-size: 13px; color: var(--text-muted); margin-bottom: 20px;
            line-height: 1.6;
        }
        .delete-modal-name {
            font-weight: 600; color: var(--text);
        }

        /* ════════════════════════════════════════════
           TOAST NOTIFICATION
        ════════════════════════════════════════════ */
        #toast-container {
            position: fixed;
            top: 20px; right: 20px;
            z-index: 9999;
            display: flex; flex-direction: column; gap: 10px;
            pointer-events: none;
        }
        .toast {
            display: flex; align-items: flex-start; gap: 12px;
            background: var(--white);
            border-radius: 10px;
            padding: 14px 16px;
            min-width: 300px; max-width: 380px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            border-left: 4px solid var(--primary);
            pointer-events: all;
            animation: toastIn 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards;
        }
        .toast.toast-success { border-left-color: var(--success); }
        .toast.toast-error   { border-left-color: var(--danger); }
        .toast.toast-warning { border-left-color: var(--warning); }
        .toast.toast-info    { border-left-color: #3b82f6; }
        .toast.hiding {
            animation: toastOut 0.3s ease forwards;
        }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(60px) scale(0.9); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes toastOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to   { opacity: 0; transform: translateX(60px) scale(0.9); }
        }
        .toast-icon {
            width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700;
        }
        .toast-success .toast-icon { background: #dcfce7; color: #16a34a; }
        .toast-error   .toast-icon { background: #fee2e2; color: #dc2626; }
        .toast-warning .toast-icon { background: #fef3c7; color: #d97706; }
        .toast-info    .toast-icon { background: #dbeafe; color: #3b82f6; }
        .toast-content { flex: 1; }
        .toast-title { font-size: 13px; font-weight: 600; margin-bottom: 2px; }
        .toast-msg { font-size: 12px; color: var(--text-muted); line-height: 1.4; }
        .toast-close {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-size: 16px; padding: 0;
            line-height: 1; flex-shrink: 0; margin-top: 1px;
        }
        .toast-close:hover { color: var(--text); }
        .toast-progress {
            position: absolute; bottom: 0; left: 0;
            height: 3px; border-radius: 0 0 10px 10px;
            background: currentColor; opacity: 0.3;
            animation: toastProgress 4s linear forwards;
        }
        @keyframes toastProgress {
            from { width: 100%; }
            to   { width: 0%; }
        }
        .toast { position: relative; overflow: hidden; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── Toast Container ─────────────────────────────────────────────── --}}
<div id="toast-container"></div>

{{-- ── Delete Confirm Modal ─────────────────────────────────────────── --}}
<div class="modal-backdrop" id="delete-modal-backdrop">
    <div class="modal modal-sm">
        <div class="modal-body" style="padding: 28px 24px 20px">
            <div class="delete-modal-icon">&#128465;</div>
            <div class="delete-modal-title">Hapus Data?</div>
            <div class="delete-modal-desc" id="delete-modal-desc">
                Apakah Anda yakin ingin menghapus <span class="delete-modal-name" id="delete-modal-name"></span>?
                <br>Tindakan ini tidak dapat dibatalkan.
            </div>
            <div style="display:flex; gap:10px; justify-content:center">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <form id="delete-modal-form" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── Sidebar overlay (mobile) ────────────────────────────────────── --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ── Sidebar ──────────────────────────────────────────────────────── --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe"
             style="height:44px;width:44px;object-fit:contain;margin-bottom:8px;display:block">
        <span>Panel Admin</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-dot"></span> Dashboard
            @if(isset($pendingWaiterCallsCount) && $pendingWaiterCallsCount > 0)
                <span class="waiter-badge">{{ $pendingWaiterCallsCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.orders.monitor') }}" class="nav-link {{ request()->routeIs('admin.orders.monitor') ? 'active' : '' }}">
            <span class="nav-dot"></span> Monitor Pesanan
        </a>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
            <span class="nav-dot"></span> Riwayat Pesanan
        </a>
        <div class="nav-section">Katalog</div>
        <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
            <span class="nav-dot"></span> Menu
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="nav-dot"></span> Kategori
        </a>
        <div class="nav-section">Operasional</div>
        <a href="{{ route('admin.tables.index') }}" class="nav-link {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
            <span class="nav-dot"></span> Meja
        </a>
        <a href="{{ route('admin.promos.index') }}" class="nav-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
            <span class="nav-dot"></span> Promo
        </a>
        <a href="{{ route('admin.feedback.index') }}" class="nav-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <span class="nav-dot"></span> Feedback
        </a>
        <a href="{{ route('admin.waiter-calls.index') }}" class="nav-link {{ request()->routeIs('admin.waiter-calls.*') ? 'active' : '' }}">
            <span class="nav-dot"></span> Waiter Calls
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-dot"></span> Manajemen User
        </a>
        <div style="margin-top:8px;border-top:1px solid rgba(255,255,255,0.15);padding-top:8px">
            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="nav-dot"></span> Logout
                </button>
            </form>
        </div>
    </nav>
    <div class="sidebar-footer">{{ auth('admin')->user()->name ?? '' }}</div>
</aside>

{{-- ── Main ─────────────────────────────────────────────────────────── --}}
<div class="main-wrapper">
    <header class="topbar">
        <div style="display:flex;align-items:center">
            <button class="hamburger" id="hamburger-btn" onclick="toggleSidebar()" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-actions">
            <span class="admin-name">{{ auth('admin')->user()->name ?? '' }}</span>
        </div>
    </header>

    <main class="content">
        @yield('content')
    </main>
</div>

{{-- ── Global JS ────────────────────────────────────────────────────── --}}
<script>
/* ── Hamburger sidebar (mobile) ────────────────────────────────────── */
function toggleSidebar() {
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const isOpen   = sidebar.classList.contains('open');
    if (isOpen) {
        closeSidebar();
    } else {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('show');
    document.body.style.overflow = '';
}
// Close sidebar when nav link clicked on mobile
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sidebar .nav-link, .sidebar .logout-btn').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });
});

/* ── Sortable Table ─────────────────────────────────────────────────── */
/**
 * Panggil initSortableTable('#id-table') setelah DOM ready
 * atau tambahkan class "sortable" ke <table> untuk auto-init.
 * Header th yang ingin bisa di-sort cukup tidak punya class "no-sort".
 */
function initSortableTable(tableSelector) {
    const table = typeof tableSelector === 'string'
        ? document.querySelector(tableSelector)
        : tableSelector;
    if (!table) return;

    const headers = table.querySelectorAll('thead th');
    let sortCol = -1, sortAsc = true;

    headers.forEach((th, colIdx) => {
        if (th.classList.contains('no-sort')) return;

        th.style.cursor = 'pointer';
        th.style.userSelect = 'none';
        th.style.whiteSpace = 'nowrap';

        // Tambah indikator sort
        const indicator = document.createElement('span');
        indicator.className = 'sort-indicator';
        indicator.style.cssText = 'margin-left:5px;font-size:10px;opacity:0.4;display:inline-block';
        indicator.textContent = '⇅';
        th.appendChild(indicator);

        th.addEventListener('click', () => {
            if (sortCol === colIdx) {
                sortAsc = !sortAsc;
            } else {
                sortCol = colIdx;
                sortAsc = true;
            }

            // Reset semua indikator
            headers.forEach(h => {
                const ind = h.querySelector('.sort-indicator');
                if (ind) { ind.textContent = '⇅'; ind.style.opacity = '0.4'; }
            });

            // Set indikator aktif
            indicator.textContent = sortAsc ? '↑' : '↓';
            indicator.style.opacity = '1';
            indicator.style.color = 'var(--primary, #0e6446)';

            // Sort rows
            const tbody = table.querySelector('tbody');
            const rows  = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const aCell = a.querySelectorAll('td')[colIdx];
                const bCell = b.querySelectorAll('td')[colIdx];
                if (!aCell || !bCell) return 0;

                const aText = aCell.innerText.trim().toLowerCase();
                const bText = bCell.innerText.trim().toLowerCase();

                // Coba parse angka (termasuk format Rp)
                const aNum = parseFloat(aText.replace(/[^0-9,.-]/g, '').replace(',', '.'));
                const bNum = parseFloat(bText.replace(/[^0-9,.-]/g, '').replace(',', '.'));

                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return sortAsc ? aNum - bNum : bNum - aNum;
                }
                return sortAsc
                    ? aText.localeCompare(bText, 'id')
                    : bText.localeCompare(aText, 'id');
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    });
}

// Auto-init semua table dengan class "sortable"
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('table.sortable').forEach(t => initSortableTable(t));
});

/* ── Toast ─────────────────────────────────────────────────────────── */
function showToast(type, title, message, duration = 4000) {
    const icons = { success: '✓', error: '✕', warning: '!', info: 'i' };
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon">${icons[type] || 'i'}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            ${message ? `<div class="toast-msg">${message}</div>` : ''}
        </div>
        <button class="toast-close" onclick="dismissToast(this.parentElement)">×</button>
        <div class="toast-progress" style="color:${type==='success'?'#16a34a':type==='error'?'#dc2626':type==='warning'?'#d97706':'#3b82f6'}"></div>
    `;
    container.appendChild(toast);
    setTimeout(() => dismissToast(toast), duration);
}

function dismissToast(toast) {
    if (!toast || toast.classList.contains('hiding')) return;
    toast.classList.add('hiding');
    setTimeout(() => toast.remove(), 300);
}

/* ── Delete Modal ──────────────────────────────────────────────────── */
function confirmDelete(action, name, desc) {
    document.getElementById('delete-modal-name').textContent = name || '';
    if (desc) document.getElementById('delete-modal-desc').innerHTML = desc;
    const form = document.getElementById('delete-modal-form');
    form.action = action;
    // reset method field
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.appendChild(methodInput);
    }
    methodInput.value = 'DELETE';
    document.getElementById('delete-modal-backdrop').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('delete-modal-backdrop').classList.remove('open');
    document.body.style.overflow = '';
}

/* ── Generic Modal ─────────────────────────────────────────────────── */
function openModal(id) {
    const el = document.getElementById(id);
    if (el) {
        el.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(id) {
    const el = document.getElementById(id);
    if (el) {
        el.classList.remove('open');
        document.body.style.overflow = '';
    }
}

// Close modal on backdrop click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-backdrop')) {
        e.target.classList.remove('open');
        document.body.style.overflow = '';
    }
});

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-backdrop.open').forEach(el => {
            el.classList.remove('open');
            document.body.style.overflow = '';
        });
    }
});

/* ── Auto-show toasts from session ────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
    @endif
    @if(session('error'))
        showToast('error', 'Gagal', @json(session('error')));
    @endif
    @if(session('info'))
        showToast('info', 'Info', @json(session('info')));
    @endif
    @if(session('warning'))
        showToast('warning', 'Perhatian', @json(session('warning')));
    @endif

    // If there are validation errors, open the correct modal
    @if($errors->any() && session('open_modal'))
        openModal(@json(session('open_modal')));
    @endif
});
</script>

@stack('scripts')
</body>
</html>
