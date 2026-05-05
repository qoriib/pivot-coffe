@extends('layouts.customer')

@section('title', $menu->name . ' — Pivot Caffe')

@section('content')
<div style="margin-bottom:12px">
    <a href="{{ route('customer.menu', $table->qr_token) }}" style="color:#0e6446;font-size:13px;text-decoration:none">
        &larr; Kembali ke Menu
    </a>
</div>

<div class="card">
    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}"
         style="width:100%;height:220px;object-fit:cover">
    <div class="card-body">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
            <h1 style="font-size:20px;font-weight:700">{{ $menu->name }}</h1>
            @if(!$menu->is_available)
                <span class="badge badge-danger">Tidak Tersedia</span>
            @endif
        </div>
        <div style="font-size:13px;color:#6b7280;margin-bottom:4px">{{ $menu->category->name }}</div>
        <div style="font-size:22px;font-weight:700;color:#0e6446;margin-bottom:12px">
            Rp {{ number_format($menu->price, 0, ',', '.') }}
        </div>
        @if($menu->description)
        <p style="font-size:14px;color:#374151;line-height:1.7;margin-bottom:16px">{{ $menu->description }}</p>
        @endif

        @if($menu->is_available)
        <form action="{{ route('customer.cart.add', $table->qr_token) }}" method="POST">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                <label style="font-size:14px;font-weight:500">Jumlah:</label>
                <div style="display:flex;align-items:center;gap:8px">
                    <button type="button" onclick="changeQty(this,-1)"
                        style="width:36px;height:36px;border:1px solid #d7d7d7;background:white;border-radius:8px;font-size:18px;cursor:pointer">-</button>
                    <input type="number" name="quantity" value="1" min="1" max="99"
                        style="width:50px;text-align:center;border:1px solid #d7d7d7;border-radius:8px;padding:6px;font-size:15px;font-family:'Poppins',sans-serif">
                    <button type="button" onclick="changeQty(this,1)"
                        style="width:36px;height:36px;border:1px solid #d7d7d7;background:white;border-radius:8px;font-size:18px;cursor:pointer">+</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Tambah ke Keranjang</button>
        </form>
        @else
        <div style="text-align:center;padding:16px;background:#fee2e2;border-radius:8px;color:#991b1b;font-size:14px">
            Menu ini sedang tidak tersedia.
        </div>
        @endif
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
