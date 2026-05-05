@extends('layouts.customer')

@section('title', 'Menu — Pivot Caffe')

@push('styles')
<style>
/* ══ LAYOUT DESKTOP 2-KOLOM ══════════════════════════════════════════ */
.menu-layout {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

@media (min-width: 900px) {
    .menu-layout {
        flex-direction: row;
        align-items: flex-start;
        gap: 28px;
    }
    .menu-sidebar {
        width: 280px;
        flex-shrink: 0;
        position: sticky;
        top: 76px; /* topbar height + gap */
    }
    .menu-main { flex: 1; min-width: 0; }
}

/* ══ SIDEBAR PANEL ═══════════════════════════════════════════════════ */
.sidebar-panel {
    background: white;
    border: 1px solid #d7d7d7;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
}
.sidebar-panel-header {
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 700;
    border-bottom: 1px solid #f0f0f0;
    color: #1a1a1a;
}
.sidebar-panel-body { padding: 12px 16px; }

/* ══ CATEGORY LIST (sidebar desktop) ════════════════════════════════ */
.cat-list { display: flex; flex-direction: column; gap: 2px; }
.cat-list-item {
    display: block;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    color: #374151;
    transition: background 0.12s, color 0.12s;
}
.cat-list-item:hover { background: #f0fdf4; color: #0e6446; }
.cat-list-item.active { background: #0e6446; color: white; font-weight: 600; }

/* ══ CATEGORY TABS (mobile) ══════════════════════════════════════════ */
.category-tabs {
    display: flex; gap: 8px; overflow-x: auto;
    padding-bottom: 4px; margin-bottom: 16px;
    scrollbar-width: none;
}
.category-tabs::-webkit-scrollbar { display: none; }
.cat-btn {
    flex-shrink: 0; padding: 6px 14px; border-radius: 20px;
    border: 1px solid #d7d7d7; background: white;
    font-family: 'Poppins', sans-serif; font-size: 13px;
    cursor: pointer; white-space: nowrap; text-decoration: none; color: #1a1a1a;
    transition: all 0.12s;
}
.cat-btn.active { background: #0e6446; color: white; border-color: #0e6446; }

/* ══ PROMO CHIPS ═════════════════════════════════════════════════════ */
.promo-item {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 12px;
    border: 1.5px solid #d7d7d7;
    border-radius: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    background: white;
}
.promo-item:hover { border-color: #0e6446; background: #f0fdf4; }
.promo-item.applied { border-color: #0e6446; background: #dcfce7; }
.promo-code { font-size: 13px; font-weight: 700; font-family: monospace; color: #0e6446; }
.promo-desc { font-size: 11px; color: #6b7280; margin-top: 1px; }
.promo-value { font-size: 12px; font-weight: 700; color: #0e6446; white-space: nowrap; }
.promo-applied-badge {
    font-size: 10px; font-weight: 700; background: #0e6446; color: white;
    padding: 2px 7px; border-radius: 20px; margin-left: 6px;
}

/* ══ SEARCH ══════════════════════════════════════════════════════════ */
.search-wrap { position: relative; margin-bottom: 16px; }
.search-wrap input {
    width: 100%; padding: 10px 16px 10px 40px;
    border: 1px solid #d7d7d7; border-radius: 10px;
    font-family: 'Poppins', sans-serif; font-size: 14px;
    background: white;
}
.search-wrap input:focus { outline: none; border-color: #0e6446; }
.search-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #9ca3af; pointer-events: none;
}

/* ══ MENU GRID ═══════════════════════════════════════════════════════ */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}
@media (min-width: 640px) and (max-width: 899px) {
    .menu-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (min-width: 900px) {
    .menu-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
}
@media (min-width: 1100px) {
    .menu-grid { grid-template-columns: repeat(4, 1fr); }
}

.menu-card {
    background: white; border: 1px solid #e5e7eb;
    border-radius: 12px; overflow: hidden;
    display: flex; flex-direction: column;
    transition: box-shadow 0.15s, transform 0.15s;
}
.menu-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-2px); }
.menu-card img { width: 100%; height: 130px; object-fit: cover; display: block; }
.menu-card-body { padding: 10px 12px 12px; flex: 1; display: flex; flex-direction: column; }
.menu-name { font-size: 13px; font-weight: 600; margin-bottom: 3px; line-height: 1.3; }
.menu-desc { font-size: 11px; color: #6b7280; flex: 1; margin-bottom: 6px; line-height: 1.4; }
.menu-price { font-size: 14px; font-weight: 700; color: #0e6446; margin-bottom: 8px; }

.qty-row { display: flex; align-items: center; gap: 6px; margin-bottom: 6px; }
.qty-btn {
    width: 28px; height: 28px; border: 1px solid #d7d7d7;
    background: white; border-radius: 6px; font-size: 16px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    font-family: 'Poppins', sans-serif; transition: background 0.1s;
}
.qty-btn:hover { background: #f0fdf4; border-color: #0e6446; }
.qty-input {
    flex: 1; text-align: center; border: 1px solid #d7d7d7;
    border-radius: 6px; padding: 4px; font-size: 13px;
    font-family: 'Poppins', sans-serif;
}

/* ══ BEST SELLERS ════════════════════════════════════════════════════ */
.bs-scroll { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 4px; scrollbar-width: none; }
.bs-scroll::-webkit-scrollbar { display: none; }
.bs-card {
    flex-shrink: 0; width: 120px; background: white;
    border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden;
    text-decoration: none; color: inherit;
    transition: box-shadow 0.15s;
}
.bs-card:hover { box-shadow: 0 3px 12px rgba(0,0,0,0.08); }
.bs-card img { width: 100%; height: 75px; object-fit: cover; }
.bs-card-body { padding: 7px 8px; }
.bs-name { font-size: 11px; font-weight: 600; line-height: 1.3; }
.bs-price { font-size: 11px; color: #0e6446; font-weight: 700; margin-top: 2px; }

/* ══ RESPONSIVE SHOW/HIDE ════════════════════════════════════════════ */

/* Sidebar: sembunyi di mobile, tampil di desktop */
.menu-sidebar { display: none; }
@media (min-width: 900px) {
    .menu-sidebar { display: block; }
}

/* Category tabs + best seller mobile: tampil di mobile, sembunyi di desktop */
.mobile-only-tabs,
.mobile-only-bs,
.mobile-only-promo {
    display: flex;
}
.mobile-only-tabs  { flex-wrap: nowrap; }
.mobile-only-bs    { flex-direction: column; }
.mobile-only-promo { flex-direction: column; }
@media (min-width: 900px) {
    .mobile-only-tabs  { display: none !important; }
    .mobile-only-bs    { display: none !important; }
    .mobile-only-promo { display: none !important; }
}
</style>
@endpush

@section('content')

@php
    $cartCount = collect($cart)->sum('quantity');
    $cartTotal = collect($cart)->sum(fn($i) => $i['unit_price'] * $i['quantity']);
    $appliedPromo = session('applied_promo_' . $table->id);
@endphp

{{-- ══ WAITER FAB ══════════════════════════════════════════════════════ --}}
<form action="{{ route('customer.waiter', $table->qr_token) }}" method="POST"
      style="position:fixed;bottom:24px;right:20px;z-index:200" class="no-print">
    @csrf
    <button type="submit" class="waiter-fab">Panggil Pelayan</button>
</form>

{{-- ══ 2-COLUMN LAYOUT ═════════════════════════════════════════════════ --}}
<div class="menu-layout">

    {{-- ── SIDEBAR (desktop) ──────────────────────────────────────────── --}}
    <aside class="menu-sidebar">

        {{-- Kategori --}}
        <div class="sidebar-panel">
            <div class="sidebar-panel-header">Kategori</div>
            <div class="sidebar-panel-body" style="padding:8px">
                <div class="cat-list">
                    <a href="{{ route('customer.menu', $table->qr_token) }}{{ $search ? '?search='.$search : '' }}"
                       class="cat-list-item {{ !$selectedCategory ? 'active' : '' }}">
                        Semua Menu
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('customer.menu', $table->qr_token) }}?category={{ $cat->slug }}{{ $search ? '&search='.$search : '' }}"
                       class="cat-list-item {{ $selectedCategory === $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Promo Aktif --}}
        @if($promos->count() > 0)
        <div class="sidebar-panel">
            <div class="sidebar-panel-header">Promo Aktif</div>
            <div class="sidebar-panel-body">
                @foreach($promos as $promo)
                <div class="promo-item {{ $appliedPromo === $promo->code ? 'applied' : '' }}"
                     onclick="applyPromo('{{ $promo->code }}', this)"
                     title="Klik untuk pakai promo ini">
                    <div>
                        <div class="promo-code">
                            {{ $promo->code }}
                            @if($appliedPromo === $promo->code)
                                <span class="promo-applied-badge">Dipakai</span>
                            @endif
                        </div>
                        <div class="promo-desc">{{ $promo->description }}</div>
                    </div>
                    <div class="promo-value">
                        @if($promo->discount_type === 'percent')
                            {{ $promo->discount_value }}% OFF
                        @else
                            Rp {{ number_format($promo->discount_value, 0, ',', '.') }} OFF
                        @endif
                    </div>
                </div>
                @endforeach
                <p style="font-size:11px;color:#9ca3af;margin-top:4px">Klik promo untuk memilih. Kode akan otomatis diisi saat checkout.</p>
            </div>
        </div>
        @endif

        {{-- Best Sellers (desktop: di sidebar) --}}
        @if($bestSellers->count() > 0)
        <div class="sidebar-panel">
            <div class="sidebar-panel-header">Terlaris</div>
            <div class="sidebar-panel-body" style="padding:10px 12px">
                <div class="bs-scroll">
                    @foreach($bestSellers as $bs)
                    <a href="{{ route('customer.menu.detail', [$table->qr_token, $bs]) }}" class="bs-card">
                        <img src="{{ $bs->image_url }}" alt="{{ $bs->name }}">
                        <div class="bs-card-body">
                            <div class="bs-name">{{ $bs->name }}</div>
                            <div class="bs-price">Rp {{ number_format($bs->price, 0, ',', '.') }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </aside>

    {{-- ── MAIN CONTENT ────────────────────────────────────────────────── --}}
    <div class="menu-main">

        {{-- Best Sellers — mobile only (di desktop ada di sidebar) --}}
        @if($bestSellers->count() > 0)
        <div class="mobile-only-bs" style="margin-bottom:20px;flex-direction:column">
            <div class="section-title">Terlaris</div>
            <div class="bs-scroll">
                @foreach($bestSellers as $bs)
                <a href="{{ route('customer.menu.detail', [$table->qr_token, $bs]) }}" class="bs-card">
                    <img src="{{ $bs->image_url }}" alt="{{ $bs->name }}">
                    <div class="bs-card-body">
                        <div class="bs-name">{{ $bs->name }}</div>
                        <div class="bs-price">Rp {{ number_format($bs->price, 0, ',', '.') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Promo Aktif — mobile only (di desktop ada di sidebar) --}}
        @if($promos->count() > 0)
        <div class="mobile-only-promo" style="margin-bottom:16px">
            <div class="section-title">Promo Aktif</div>
            @foreach($promos as $promo)
            <div class="promo-item {{ $appliedPromo === $promo->code ? 'applied' : '' }}"
                 onclick="applyPromo('{{ $promo->code }}', this)"
                 title="Klik untuk pakai promo ini">
                <div>
                    <div class="promo-code">
                        {{ $promo->code }}
                        @if($appliedPromo === $promo->code)
                            <span class="promo-applied-badge">Dipakai</span>
                        @endif
                    </div>
                    <div class="promo-desc">{{ $promo->description }}</div>
                </div>
                <div class="promo-value">
                    @if($promo->discount_type === 'percent')
                        {{ $promo->discount_value }}% OFF
                    @else
                        Rp {{ number_format($promo->discount_value, 0, ',', '.') }} OFF
                    @endif
                </div>
            </div>
            @endforeach
            <p style="font-size:11px;color:#9ca3af;margin-top:4px">Klik promo untuk memilih. Kode otomatis diisi saat checkout.</p>
        </div>
        @endif

        {{-- Search --}}
        <div class="search-wrap">
            <form method="GET" action="{{ route('customer.menu', $table->qr_token) }}">
                @if($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari menu...">
            </form>
        </div>

        {{-- Category tabs — mobile only, disembunyikan di desktop via CSS --}}
        <div class="category-tabs mobile-only-tabs">
            <a href="{{ route('customer.menu', $table->qr_token) }}{{ $search ? '?search='.$search : '' }}"
               class="cat-btn {{ !$selectedCategory ? 'active' : '' }}">Semua</a>
            @foreach($categories as $cat)
            <a href="{{ route('customer.menu', $table->qr_token) }}?category={{ $cat->slug }}{{ $search ? '&search='.$search : '' }}"
               class="cat-btn {{ $selectedCategory === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        {{-- Menu Grid --}}
        <div class="section-title" style="margin-top:4px">
            {{ $selectedCategory ? $categories->firstWhere('slug', $selectedCategory)?->name ?? 'Menu' : 'Semua Menu' }}
            <span style="font-size:12px;font-weight:400;color:#6b7280;margin-left:6px">{{ $menus->count() }} item</span>
        </div>

        <div class="menu-grid">
            @forelse($menus as $menu)
            <div class="menu-card">
                <a href="{{ route('customer.menu.detail', [$table->qr_token, $menu]) }}">
                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy">
                </a>
                <div class="menu-card-body">
                    <div class="menu-name">{{ $menu->name }}</div>
                    <div class="menu-desc">{{ Str::limit($menu->description, 55) }}</div>
                    <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>

                    @if($menu->is_available)
                    <form action="{{ route('customer.cart.add', $table->qr_token) }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <div class="qty-row">
                            <button type="button" class="qty-btn" onclick="changeQty(this,-1)">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="99" class="qty-input">
                            <button type="button" class="qty-btn" onclick="changeQty(this,1)">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="width:100%;font-size:12px">
                            Tambah
                        </button>
                    </form>
                    @else
                    <div style="text-align:center;padding:8px 0">
                        <span class="badge badge-danger">Tidak Tersedia</span>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:48px 0;color:#6b7280">
                Tidak ada menu yang ditemukan.
            </div>
            @endforelse
        </div>

    </div>{{-- end .menu-main --}}
</div>{{-- end .menu-layout --}}

@endsection

@push('scripts')
<script>
/* ── Qty control ─────────────────────────────────────────────────── */
function changeQty(btn, delta) {
    const input = btn.parentElement.querySelector('input[type="number"]');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 99) val = 99;
    input.value = val;
}

/* ── Promo — radio style, default promo pertama ──────────────────── */
const PROMO_KEY = 'cp_promo_{{ $table->id }}';
const DEFAULT_PROMO = '{{ $promos->first()?->code ?? '' }}';

function applyPromo(code, el) {
    // Selalu set — tidak bisa deselect, hanya bisa pindah ke promo lain
    sessionStorage.setItem(PROMO_KEY, code);

    // Reset semua promo item
    document.querySelectorAll('.promo-item').forEach(p => {
        p.classList.remove('applied');
        const badge = p.querySelector('.promo-applied-badge');
        if (badge) badge.remove();
    });

    // Tandai yang dipilih
    el.classList.add('applied');
    const codeEl = el.querySelector('.promo-code');
    if (!codeEl.querySelector('.promo-applied-badge')) {
        const badge = document.createElement('span');
        badge.className = 'promo-applied-badge';
        badge.textContent = 'Dipakai';
        codeEl.appendChild(badge);
    }

    cToast('Promo ' + code + ' dipilih!', 'success');
    updateCartDrawer();
}

function restorePromo() {
    let saved = sessionStorage.getItem(PROMO_KEY);

    // Jika belum ada pilihan sama sekali, set default ke promo pertama
    if (!saved && DEFAULT_PROMO) {
        saved = DEFAULT_PROMO;
        sessionStorage.setItem(PROMO_KEY, saved);
    }

    if (!saved) return;

    document.querySelectorAll('.promo-item').forEach(el => {
        const codeEl = el.querySelector('.promo-code');
        if (!codeEl) return;
        // Ambil teks kode saja (trim, tanpa badge text)
        const codeText = Array.from(codeEl.childNodes)
            .filter(n => n.nodeType === Node.TEXT_NODE)
            .map(n => n.textContent.trim())
            .join('').trim();
        if (codeText === saved) {
            el.classList.add('applied');
            if (!codeEl.querySelector('.promo-applied-badge')) {
                const badge = document.createElement('span');
                badge.className = 'promo-applied-badge';
                badge.textContent = 'Dipakai';
                codeEl.appendChild(badge);
            }
        }
    });
}

/* ── Cart drawer data ────────────────────────────────────────────── */
const cartData = @json($cart);
const checkoutUrl = '{{ route('customer.checkout', $table->qr_token) }}';
const clearUrl    = '{{ route('customer.cart.clear', $table->qr_token) }}';
const updateUrl   = '{{ route('customer.cart.update', $table->qr_token) }}';
const removeUrl   = '{{ route('customer.cart.remove', $table->qr_token) }}';
const csrfToken   = document.querySelector('meta[name="csrf-token"]')?.content
                 || '{{ csrf_token() }}';

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function updateCartDrawer() {
    const body   = document.getElementById('cart-drawer-body');
    const footer = document.getElementById('cart-drawer-footer');
    const badge  = document.getElementById('cart-badge-count');
    const btn    = document.getElementById('cart-icon-btn');

    const keys = Object.keys(cartData);
    const totalQty = keys.reduce((s, k) => s + cartData[k].quantity, 0);
    const subtotal = keys.reduce((s, k) => s + cartData[k].unit_price * cartData[k].quantity, 0);

    // Badge
    if (totalQty > 0) {
        badge.textContent = totalQty > 99 ? '99+' : totalQty;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }

    if (keys.length === 0) {
        body.innerHTML = '<div style="text-align:center;padding:48px 0;color:#6b7280;font-size:13px">Keranjang masih kosong</div>';
        footer.style.display = 'none';
        return;
    }

    // Build items HTML
    let html = '';
    keys.forEach(menuId => {
        const item = cartData[menuId];
        html += `
        <div class="cart-item-row">
            <div class="cart-item-info">
                <div class="cart-item-name">${item.name}</div>
                <div class="cart-item-price">${formatRp(item.unit_price)} / item</div>
            </div>
            <div class="cart-qty-ctrl">
                <button class="cart-qty-btn" onclick="cartUpdate(${menuId}, ${item.quantity - 1})">−</button>
                <span class="cart-qty-num">${item.quantity}</span>
                <button class="cart-qty-btn" onclick="cartUpdate(${menuId}, ${item.quantity + 1})">+</button>
            </div>
            <div class="cart-item-subtotal">${formatRp(item.unit_price * item.quantity)}</div>
            <button onclick="cartRemove(${menuId})" style="background:none;border:1px solid #fecaca;border-radius:6px;cursor:pointer;color:#dc2626;padding:4px 6px;display:flex;align-items:center;justify-content:center;flex-shrink:0" title="Hapus">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
        </div>`;
    });
    body.innerHTML = html;

    // Footer
    document.getElementById('cart-subtotal-display').textContent = formatRp(subtotal);
    document.getElementById('cart-total-display').textContent = formatRp(subtotal);

    // Checkout link with promo
    const promo = sessionStorage.getItem(PROMO_KEY);
    let url = checkoutUrl;
    if (promo) url += '?promo=' + encodeURIComponent(promo);
    document.getElementById('cart-checkout-btn').href = url;

    // Clear form
    document.getElementById('cart-clear-form').action = clearUrl;

    footer.style.display = 'block';
}

function cartUpdate(menuId, qty) {
    if (qty < 1) { cartRemove(menuId); return; }
    const fd = new FormData();
    fd.append('_token', csrfToken);
    fd.append('menu_id', menuId);
    fd.append('quantity', qty);
    fetch(updateUrl, { method: 'POST', body: fd })
        .then(r => { if (r.ok) { cartData[menuId].quantity = qty; updateCartDrawer(); } });
}

function cartRemove(menuId) {
    const fd = new FormData();
    fd.append('_token', csrfToken);
    fd.append('menu_id', menuId);
    fetch(removeUrl, { method: 'POST', body: fd })
        .then(r => { if (r.ok) { delete cartData[menuId]; updateCartDrawer(); } });
}

/* ── Init ────────────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    updateCartDrawer();
    restorePromo();
});
</script>
@endpush
