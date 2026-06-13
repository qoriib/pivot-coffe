@extends('layouts.customer')

@section('title', 'Menu — Pivot Caffe')

@push('styles')
<style>
    /* ══ LAYOUT ══════════════════════════════════════════════════════════ */
    .menu-layout {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    @media (min-width: 992px) {
        .menu-layout {
            flex-direction: row;
            align-items: flex-start;
        }
        .menu-sidebar {
            width: 300px;
            flex-shrink: 0;
            position: sticky;
            top: 100px;
        }
        .menu-main { flex: 1; min-width: 0; }
    }

    /* ══ SIDEBAR ═════════════════════════════════════════════════════════ */
    .sidebar-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 25px;
        border: var(--border);
    }

    .sidebar-card-header {
        padding: 15px 25px;
        background: #fafafa;
        border-bottom: var(--border);
        font-weight: 700;
        font-size: 14px;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .sidebar-card-body {
        padding: 15px;
    }

    .cat-list { display: flex; flex-direction: column; gap: 5px; }
    .cat-list-item {
        display: block;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        color: var(--text-light);
        transition: all 0.3s;
    }

    .cat-list-item:hover {
        background: var(--bg);
        color: var(--primary);
        transform: translateX(5px);
    }

    .cat-list-item.active {
        background: var(--primary);
        color: white;
        font-weight: 600;
    }

    /* ══ SEARCH ══════════════════════════════════════════════════════════ */
    .search-container {
        position: relative;
        margin-bottom: 30px;
    }

    .search-container input {
        width: 100%;
        padding: 16px 25px 16px 55px;
        border-radius: 50px;
        border: var(--border);
        background: white;
        font-family: inherit;
        font-size: 15px;
        box-shadow: var(--shadow);
        transition: all 0.3s;
    }

    .search-container input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .search-icon-abs {
        position: absolute;
        left: 22px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent);
        font-size: 18px;
    }

    /* ══ MENU GRID ═══════════════════════════════════════════════════════ */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
    }

    .menu-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: var(--border);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .menu-card-img-wrap {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .menu-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .menu-card:hover .menu-card-img-wrap img {
        transform: scale(1.1);
    }

    .menu-card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .menu-item-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--primary);
    }

    .menu-item-desc {
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 15px;
        line-height: 1.5;
        flex: 1;
    }

    .menu-item-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px dashed rgba(0,0,0,0.1);
    }

    .menu-item-price {
        font-weight: 700;
        color: var(--primary);
        font-size: 16px;
    }

    .btn-add-cart {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-add-cart:hover {
        background: var(--accent);
        color: var(--primary-dark);
        transform: rotate(90deg);
    }

    /* ══ CATEGORY TABS MOBILE ════════════════════════════════════════════ */
    .mobile-tabs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 15px;
        margin-bottom: 20px;
        scrollbar-width: none;
    }
    .mobile-tabs::-webkit-scrollbar { display: none; }

    .tab-btn {
        flex-shrink: 0;
        padding: 10px 20px;
        border-radius: 50px;
        background: white;
        border: var(--border);
        font-size: 13px;
        font-weight: 600;
        color: var(--text-light);
        text-decoration: none;
        transition: all 0.3s;
    }

    .tab-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* ══ WAITER FAB ══════════════════════════════════════════════════════ */
    .waiter-fab {
        background: var(--accent);
        color: var(--primary-dark);
        padding: 15px 25px;
        border-radius: 50px;
        font-weight: 700;
        box-shadow: 0 8px 25px rgba(212, 163, 115, 0.4);
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .waiter-fab:hover {
        transform: scale(1.05) translateY(-5px);
        background: var(--accent-light);
    }

    .page-header {
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .page-header p {
        color: var(--text-light);
    }

    /* ══ BEST SELLER ════════════════════════════════════════════════════ */
    .best-seller-section {
        margin-bottom: 30px;
        background: white;
        border-radius: 22px;
        border: var(--border);
        box-shadow: var(--shadow);
        padding: 24px;
    }

    .best-seller-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .best-seller-title {
        font-size: 1.4rem;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }

    .best-seller-subtitle {
        font-size: 12px;
        color: var(--text-light);
    }

    .best-seller-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
    }

    .best-card {
        background: linear-gradient(135deg, #ffffff 0%, #fdf6ee 100%);
        border-radius: 18px;
        padding: 16px;
        border: 1px solid rgba(212, 163, 115, 0.35);
        display: flex;
        gap: 14px;
        align-items: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .best-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    .best-card img {
        width: 70px;
        height: 70px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .best-card-name {
        font-weight: 700;
        color: var(--primary);
        font-size: 15px;
        margin-bottom: 6px;
    }

    .best-card-price {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 13px;
    }

    .best-card-action {
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .best-card-badge {
        background: var(--accent);
        color: var(--primary-dark);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 4px 8px;
        border-radius: 999px;
    }

    @media (max-width: 991px) {
        .menu-sidebar { display: none; }
    }

    /* ══ PAGINATION ══════════════════════════════════════════════════════ */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 40px;
    }

    .pagination-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: var(--border);
        background: white;
        color: var(--primary);
        font-family: inherit;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow);
    }

    .pagination-btn:hover:not(.disabled) {
        background: var(--accent);
        color: var(--primary-dark);
        border-color: var(--accent);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(212, 163, 115, 0.25);
    }

    .pagination-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pagination-btn.disabled {
        color: var(--text-light);
        opacity: 0.35;
        cursor: not-allowed;
        background: transparent;
        border-color: var(--border);
        box-shadow: none;
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    
    <div class="page-header">
        <h1 class="font-serif">{{ $selectedCategory ? $categories->firstWhere('slug', $selectedCategory)?->name : 'Menu Kami' }}</h1>
        <p>Temukan kenikmatan dalam setiap pilihan menu terbaik kami.</p>
    </div>

    @php
        $cartCount = collect($cart)->sum('quantity');
        $cartTotal = collect($cart)->sum(fn($i) => $i['unit_price'] * $i['quantity']);
        $appliedPromo = session('applied_promo_' . $table->id);
    @endphp

    {{-- ══ WAITER FAB ══════════════════════════════════════════════════════ --}}
    <form action="{{ route('customer.waiter', $table->qr_token) }}" method="POST"
          style="position:fixed;bottom:30px;right:30px;z-index:200" class="no-print">
        @csrf
        <button type="submit" class="waiter-fab">
            <i class="fas fa-bell"></i>
            <span>Panggil Pelayan</span>
        </button>
    </form>

    <div class="menu-layout">
        {{-- ── SIDEBAR (desktop) ──────────────────────────────────────────── --}}
        <aside class="menu-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-card-header">Kategori</div>
                <div class="sidebar-card-body">
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

            @if($promos->count() > 0)
            <div class="sidebar-card">
                <div class="sidebar-card-header">Promo Spesial</div>
                <div class="sidebar-card-body">
                    @foreach($promos as $promo)
                    <div class="promo-card-mini" style="background: var(--bg); padding: 15px; border-radius: 15px; margin-bottom: 10px; border: 1px dashed var(--accent);">
                        <div style="font-weight: 700; color: var(--primary); font-size: 14px; margin-bottom: 5px;">{{ $promo->code }}</div>
                        <div style="font-size: 12px; color: var(--text-light); line-height: 1.4;">{{ $promo->description }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>

        {{-- ── MAIN CONTENT ────────────────────────────────────────────────── --}}
        <div class="menu-main">

            {{-- Mobile Tabs --}}
            <div class="mobile-tabs d-lg-none">
                <a href="{{ route('customer.menu', $table->qr_token) }}{{ $search ? '?search='.$search : '' }}"
                   class="tab-btn {{ !$selectedCategory ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                <a href="{{ route('customer.menu', $table->qr_token) }}?category={{ $cat->slug }}{{ $search ? '&search='.$search : '' }}"
                   class="tab-btn {{ $selectedCategory === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="search-container">
                <form method="GET" action="{{ route('customer.menu', $table->qr_token) }}">
                    @if($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    <i class="fas fa-search search-icon-abs"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari kopi favoritmu...">
                </form>
            </div>

            {{-- Best Seller --}}
            @if($bestSellers->count() > 0)
            <div class="best-seller-section">
                <div class="best-seller-header">
                    <div>
                        <div class="best-seller-title">Menu Terlaris</div>
                        <div class="best-seller-subtitle">Paling banyak dipesan minggu ini</div>
                    </div>
                    <div class="best-card-badge">Best Seller</div>
                </div>
                <div class="best-seller-grid">
                    @foreach($bestSellers as $menu)
                    <a href="{{ route('customer.menu.detail', [$table->qr_token, $menu]) }}" class="best-card">
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy">
                        <div>
                            <div class="best-card-name">{{ $menu->name }}</div>
                            <div class="best-card-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                            <div class="best-card-action">
                                <span style="font-size:11px;color:var(--text-light)">Lihat detail</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Mobile Promo --}}
            @if($promos->count() > 0)
            <div class="d-lg-none" style="margin-bottom: 25px;">
                <div class="sidebar-card" style="margin-bottom: 0;">
                    <div class="sidebar-card-header">Promo Spesial</div>
                    <div class="sidebar-card-body">
                        @foreach($promos as $promo)
                        <div class="promo-card-mini" style="background: var(--bg); padding: 15px; border-radius: 15px; margin-bottom: 10px; border: 1px dashed var(--accent);">
                            <div style="font-weight: 700; color: var(--primary); font-size: 14px; margin-bottom: 5px;">{{ $promo->code }}</div>
                            <div style="font-size: 12px; color: var(--text-light); line-height: 1.4;">{{ $promo->description }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Menu Grid --}}
            <div class="menu-grid">
                @forelse($menus as $menu)
                <div class="menu-card">
                    <a href="{{ route('customer.menu.detail', [$table->qr_token, $menu]) }}" class="menu-card-img-wrap">
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy">
                    </a>
                    <div class="menu-card-content">
                        <h3 class="menu-item-name">{{ $menu->name }}</h3>
                        <p class="menu-item-desc">{{ Str::limit($menu->description, 60) }}</p>
                        
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                            
                            @if($menu->is_available)
                            <form action="{{ route('customer.cart.add', $table->qr_token) }}" method="POST">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart" title="Tambah ke Keranjang">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                            @else
                            <span style="font-size: 11px; color: var(--danger); font-weight: 600; text-transform: uppercase;">Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 0;">
                    <i class="fas fa-coffee" style="font-size: 3rem; color: #eee; margin-bottom: 20px;"></i>
                    <p style="color: var(--text-light);">Menu tidak ditemukan. Coba kata kunci lain.</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($menus->hasPages())
            <div class="pagination-container">
                {{-- Previous Page Link --}}
                @if($menus->onFirstPage())
                    <span class="pagination-btn disabled"><i class="fas fa-chevron-left"></i></span>
                @else
                    <a href="{{ $menus->previousPageUrl() }}" class="pagination-btn"><i class="fas fa-chevron-left"></i></a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($menus->getUrlRange(1, $menus->lastPage()) as $page => $url)
                    @if ($page == $menus->currentPage())
                        <span class="pagination-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($menus->hasMorePages())
                    <a href="{{ $menus->nextPageUrl() }}" class="pagination-btn"><i class="fas fa-chevron-right"></i></a>
                @else
                    <span class="pagination-btn disabled"><i class="fas fa-chevron-right"></i></span>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Cart update logic is handled by the layout's script
</script>
@endpush
