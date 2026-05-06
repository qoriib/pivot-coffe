@extends('layouts.customer')

@section('title', $menu->name . ' — Pivot Caffe')

@push('styles')
<style>
    .detail-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: var(--border);
        display: flex;
        flex-direction: column;
        max-width: 900px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .detail-card {
            flex-direction: row;
            min-height: 500px;
        }
        .detail-img-side {
            width: 45%;
            flex-shrink: 0;
        }
        .detail-content-side {
            padding: 50px !important;
        }
    }

    .detail-img-side {
        position: relative;
        height: 350px;
    }

    @media (min-width: 768px) {
        .detail-img-side { height: auto; }
    }

    .detail-img-side img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-content-side {
        padding: 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--text-light);
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 25px;
        transition: color 0.3s;
    }

    .back-link:hover {
        color: var(--primary);
    }

    .detail-category {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .detail-name {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .detail-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 25px;
    }

    .detail-desc {
        color: var(--text-light);
        line-height: 1.8;
        margin-bottom: 35px;
        font-size: 15px;
    }

    .qty-picker {
        display: flex;
        align-items: center;
        gap: 15px;
        background: var(--bg);
        padding: 8px 15px;
        border-radius: 50px;
        width: fit-content;
        margin-bottom: 30px;
    }

    .qty-ctrl-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: white;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .qty-ctrl-btn:hover {
        background: var(--primary);
        color: white;
    }

    .qty-input-field {
        background: transparent;
        border: none;
        width: 40px;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        font-family: inherit;
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    
    <a href="{{ route('customer.menu', $table->qr_token) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Menu</span>
    </a>

    <div class="detail-card fade-in-up">
        <div class="detail-img-side">
            <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}">
            @if(!$menu->is_available)
            <div style="position: absolute; top: 20px; right: 20px; background: var(--danger); color: white; padding: 5px 15px; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                Tidak Tersedia
            </div>
            @endif
        </div>
        
        <div class="detail-content-side">
            <div class="detail-category">{{ $menu->category->name }}</div>
            <h1 class="detail-name">{{ $menu->name }}</h1>
            <div class="detail-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
            
            @if($menu->description)
            <div class="detail-desc">{{ $menu->description }}</div>
            @endif

            @if($menu->is_available)
            <form action="{{ route('customer.cart.add', $table->qr_token) }}" method="POST">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                
                <div style="font-weight: 600; font-size: 14px; margin-bottom: 12px; color: var(--text);">Jumlah Pesanan:</div>
                <div class="qty-picker">
                    <button type="button" class="qty-ctrl-btn" onclick="changeQty(this, -1)"><i class="fas fa-minus"></i></button>
                    <input type="number" name="quantity" value="1" min="1" max="99" class="qty-input-field">
                    <button type="button" class="qty-ctrl-btn" onclick="changeQty(this, 1)"><i class="fas fa-plus"></i></button>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" style="padding: 18px;">
                    <i class="fas fa-shopping-basket" style="margin-right: 10px;"></i>
                    Tambah ke Keranjang
                </button>
            </form>
            @else
            <div style="padding: 20px; background: #fff5f5; border-radius: 15px; border: 1px solid #fed7d7; color: #c53030; text-align: center;">
                <i class="fas fa-info-circle" style="margin-bottom: 10px; font-size: 1.2rem; display: block;"></i>
                Maaf, menu ini sedang tidak tersedia saat ini.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function changeQty(btn, delta) {
    const input = btn.parentElement.querySelector('input[type="number"]');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 99) val = 99;
    input.value = val;
}
</script>
@endpush
