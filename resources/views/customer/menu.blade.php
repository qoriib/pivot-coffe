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

    /* ══ PROMO SPECIAL SECTION ══════════════════════════════════════════ */
    .promo-section {
        margin-bottom: 30px;
    }

    .promo-section-title {
        font-size: 1.4rem;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .promo-slider {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
        padding-bottom: 5px;
    }

    .promo-slider::-webkit-scrollbar {
        display: none; /* Safari/Chrome */
    }

    .promo-slide {
        flex-shrink: 0;
        width: 290px;
        scroll-snap-align: start;
    }

    .promo-details {
        flex: 1;
        height: 110px;
        background-color: #ebe7e0; /* light beige */
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 16px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-sizing: border-box;
    }

    .promo-badge {
        background-color: #2e1b12; /* dark brown badge */
        color: white;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        width: fit-content;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .promo-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-top: 4px;
        margin-bottom: 2px;
    }

    .promo-desc {
        font-size: 12px;
        color: var(--text-light);
        line-height: 1.3;
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

    /* ══ DIALOG MODAL ════════════════════════════════════════════════════ */
    dialog.custom-modal {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        padding: 0;
        width: 100%;
        max-width: 420px;
        margin: auto;
        background: white;
        overflow: hidden;
    }

    dialog.custom-modal::backdrop {
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content-wrapper {
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafafa;
    }

    .modal-header h3 {
        font-size: 1.25rem;
        color: var(--primary);
    }

    .btn-close-modal {
        background: none;
        border: none;
        color: var(--text-light);
        font-size: 18px;
        cursor: pointer;
        transition: color 0.3s;
    }

    .btn-close-modal:hover {
        color: var(--primary);
    }

    .modal-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-option-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .option-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .option-card {
        position: relative;
        cursor: pointer;
    }

    .option-card input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .option-card-box {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border-radius: 12px;
        border: 2px solid #eee;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-light);
        transition: all 0.3s;
        text-align: center;
    }

    .option-card input:checked + .option-card-box {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(27, 67, 50, 0.03);
    }

    .option-card-box i {
        font-size: 14px;
    }

    .qty-selector {
        display: flex;
        align-items: center;
        border: var(--border);
        border-radius: 12px;
        overflow: hidden;
        width: fit-content;
        background: var(--bg);
    }

    .qty-selector button {
        width: 42px;
        height: 42px;
        border: none;
        background: none;
        color: var(--primary);
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s;
    }

    .qty-selector button:hover {
        background: rgba(0,0,0,0.05);
    }

    .qty-selector input {
        width: 50px;
        height: 42px;
        border: none;
        border-left: var(--border);
        border-right: var(--border);
        text-align: center;
        font-family: inherit;
        font-weight: 700;
        font-size: 15px;
        background: white;
    }

    .modal-footer {
        padding: 20px 25px;
        border-top: var(--border);
        background: #fafafa;
    }

    .form-input-p {
        width: 100%;
        padding: 14px 18px;
        border-radius: 12px;
        border: var(--border);
        background: var(--bg);
        font-family: inherit;
        font-size: 14px;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .form-input-p:focus {
        outline: none;
        border-color: var(--accent);
        background: white;
        box-shadow: 0 5px 15px rgba(212, 163, 115, 0.15);
    }

    .form-label-p {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: var(--text);
        margin-bottom: 10px;
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

            {{-- Promo Spesial Slider --}}
            @if($promos->count() > 0)
            <div class="promo-section">
                <h2 class="promo-section-title">Promo Spesial</h2>
                <div class="promo-slider">
                    @foreach($promos as $promo)
                        @php
                            $promoTitle = '';
                            $promoDesc = '';
                            if ($promo->code === 'HEMAT10') {
                                $promoTitle = 'Diskon 10%';
                                $promoDesc = 'Untuk semua menu';
                            } elseif ($promo->code === 'GRATIS5K') {
                                $promoTitle = 'Potongan 5K';
                                $promoDesc = 'Min. pembelian Rp 50rb';
                            } else {
                                $promoTitle = $promo->discount_type === 'percent' 
                                    ? 'Diskon ' . number_format($promo->discount_value, 0) . '%' 
                                    : 'Potongan ' . number_format($promo->discount_value / 1000, 0) . 'K';
                                $promoDesc = $promo->description;
                            }
                        @endphp
                        <div class="promo-slide">
                            <div class="promo-details">
                                <span class="promo-badge">{{ $promo->code }}</span>
                                <div class="promo-title">{{ $promoTitle }}</div>
                                <div class="promo-desc">{{ $promoDesc }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

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
                            <button type="button" class="btn-add-cart" title="Tambah ke Keranjang"
                                onclick="openAddCartModal({{ $menu->id }}, '{{ addslashes($menu->name) }}', '{{ $menu->category->name }}')">
                                <i class="fas fa-plus"></i>
                            </button>
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

{{-- ══ DIALOG MODAL TAMBAH KE KERANJANG ════════════════════════════════ --}}
<dialog id="add-cart-dialog" closedby="any" class="custom-modal">
    <div class="modal-content-wrapper">
        <form method="POST" action="{{ route('customer.cart.add', $table->qr_token) }}" id="add-cart-form">
            @csrf
            <input type="hidden" name="menu_id" id="modal-menu-id" value="">
            <input type="hidden" name="notes" id="modal-combined-notes" value="">
            
            <div class="modal-header">
                <h3 id="modal-menu-name" class="font-serif">Tambah ke Keranjang</h3>
                <button type="button" class="btn-close-modal" onclick="closeAddCartModal()"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="modal-body">
                {{-- Dynamic Option Groups --}}
                <div id="modal-drink-options" class="modal-option-group" style="display: none;">
                    <label class="form-label-p">Pilih Suhu</label>
                    <div class="option-grid">
                        <label class="option-card">
                            <input type="radio" name="temp_option" value="Es" checked>
                            <div class="option-card-box">
                                <i class="fas fa-snowflake" style="color: #3b82f6;"></i>
                                Es / Dingin
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="temp_option" value="Panas">
                            <div class="option-card-box">
                                <i class="fas fa-fire" style="color: #ef4444;"></i>
                                Panas
                            </div>
                        </label>
                    </div>
                </div>

                <div id="modal-food-options" class="modal-option-group" style="display: none;">
                    <label class="form-label-p">Pilih Tingkat Kepedasan</label>
                    <div class="option-grid">
                        <label class="option-card">
                            <input type="radio" name="spicy_option" value="Tidak Pedas" checked>
                            <div class="option-card-box">
                                <i class="fas fa-leaf" style="color: #10b981;"></i>
                                Tidak Pedas
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="spicy_option" value="Pedas">
                            <div class="option-card-box">
                                <i class="fas fa-pepper-hot" style="color: #ef4444;"></i>
                                Pedas
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Jumlah/Quantity --}}
                <div class="modal-option-group">
                    <label class="form-label-p">Jumlah</label>
                    <div class="qty-selector">
                        <button type="button" onclick="changeModalQty(-1)"><i class="fas fa-minus"></i></button>
                        <input type="number" name="quantity" id="modal-quantity" value="1" min="1" readonly>
                        <button type="button" onclick="changeModalQty(1)"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                {{-- Catatan tambahan --}}
                <div class="modal-option-group" style="margin-bottom: 0;">
                    <label class="form-label-p" for="modal-notes">Catatan Tambahan (Opsional)</label>
                    <textarea id="modal-notes" rows="3" class="form-input-p" style="border-radius: 12px; resize: none; line-height: 1.5;" placeholder="Contoh: es sedikit, kurang manis, tanpa bawang..."></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block">Tambahkan</button>
            </div>
        </form>
    </div>
</dialog>
@endsection

@push('scripts')
<script>
    // Cart update logic is handled by the layout's script

    // Javascript for Add to Cart Modal with Options
    const addCartDialog = document.getElementById('add-cart-dialog');
    const modalMenuId = document.getElementById('modal-menu-id');
    const modalMenuName = document.getElementById('modal-menu-name');
    const modalQty = document.getElementById('modal-quantity');
    const modalNotes = document.getElementById('modal-notes');
    const addCartForm = document.getElementById('add-cart-form');
    const modalCombinedNotes = document.getElementById('modal-combined-notes');

    function openAddCartModal(menuId, menuName, categoryName) {
        modalMenuId.value = menuId;
        modalMenuName.textContent = menuName;
        modalQty.value = 1;
        modalNotes.value = '';

        // Normalize category name for detection
        const cat = categoryName.toLowerCase();
        const isDrink = cat.includes('kopi') || cat.includes('minuman') || cat.includes('drink') || cat.includes('beverage');
        const isFood = cat.includes('makanan') || cat.includes('snack') || cat.includes('camilan') || cat.includes('food');

        const drinkOptGroup = document.getElementById('modal-drink-options');
        const foodOptGroup = document.getElementById('modal-food-options');

        // Reset radio selections to defaults if elements exist
        const defaultTempRadio = document.querySelector('input[name="temp_option"][value="Es"]');
        if (defaultTempRadio) defaultTempRadio.checked = true;

        const defaultSpicyRadio = document.querySelector('input[name="spicy_option"][value="Tidak Pedas"]');
        if (defaultSpicyRadio) defaultSpicyRadio.checked = true;

        if (isDrink) {
            drinkOptGroup.style.display = 'block';
            foodOptGroup.style.display = 'none';
            modalNotes.placeholder = "Contoh: kurang manis, es sedikit, tanpa es...";
        } else if (isFood) {
            drinkOptGroup.style.display = 'none';
            foodOptGroup.style.display = 'block';
            modalNotes.placeholder = "Contoh: tanpa bawang, ekstra keju, dll...";
        } else {
            drinkOptGroup.style.display = 'none';
            foodOptGroup.style.display = 'none';
            modalNotes.placeholder = "Contoh: sendok plastik, saus dipisah, dll...";
        }

        addCartDialog.showModal();
    }

    function closeAddCartModal() {
        addCartDialog.close();
    }

    // Combine options and custom notes before form submission
    addCartForm.addEventListener('submit', function(e) {
        let options = [];
        
        // Check if drink options are visible
        const drinkOptions = document.getElementById('modal-drink-options');
        if (drinkOptions && drinkOptions.style.display !== 'none') {
            const selectedTemp = document.querySelector('input[name="temp_option"]:checked')?.value;
            if (selectedTemp) {
                options.push(selectedTemp);
            }
        }
        
        // Check if food options are visible
        const foodOptions = document.getElementById('modal-food-options');
        if (foodOptions && foodOptions.style.display !== 'none') {
            const selectedSpicy = document.querySelector('input[name="spicy_option"]:checked')?.value;
            if (selectedSpicy) {
                options.push(selectedSpicy);
            }
        }
        
        const customText = modalNotes.value.trim();
        if (customText) {
            options.push(customText);
        }
        
        // Combine options with a comma and store in hidden input
        modalCombinedNotes.value = options.join(', ');
    });

    function changeModalQty(amount) {
        let currentVal = parseInt(modalQty.value) || 1;
        currentVal += amount;
        if (currentVal < 1) currentVal = 1;
        modalQty.value = currentVal;
    }

    // Fallback for browsers without closedby support
    if (addCartDialog && !('closedBy' in HTMLDialogElement.prototype)) {
        addCartDialog.addEventListener('click', (event) => {
            if (event.target !== addCartDialog) return;
            const rect = addCartDialog.getBoundingClientRect();
            const isDialogContent = (
                rect.top <= event.clientY &&
                event.clientY <= rect.top + rect.height &&
                rect.left <= event.clientX &&
                event.clientX <= rect.left + rect.width
            );
            if (!isDialogContent) {
                addCartDialog.close();
            }
        });
    }
</script>
@endpush
