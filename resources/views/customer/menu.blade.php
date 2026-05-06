@extends('layouts.customer')

@section('title', 'Menu — Pivot Caffe')

@push('styles')
<style>
    /* ══ LAYOUT ══════════════════════════════════════════════════════════ */
    .menu-layout {
        display: flex;
        flex-direction: column;
        gap: 30px;
        padding-bottom: 80px;
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

    @media (max-width: 991px) {
        .menu-sidebar { display: none; }
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
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Cart update logic is handled by the layout's script
</script>
@endpush
