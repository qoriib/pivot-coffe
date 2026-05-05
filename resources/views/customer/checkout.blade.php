@extends('layouts.customer')

@section('title', 'Checkout — Pivot Caffe')

@push('styles')
<style>
    .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item-name { font-size: 14px; font-weight: 500; }
    .cart-item-meta { font-size: 12px; color: #6b7280; }
    .cart-item-price { font-size: 14px; font-weight: 600; text-align: right; min-width: 80px; }
    .cart-item-actions { display: flex; align-items: center; gap: 6px; margin-top: 4px; }
    .qty-btn { width: 26px; height: 26px; border: 1px solid #d7d7d7; background: white; border-radius: 4px; font-size: 14px; cursor: pointer; display:flex;align-items:center;justify-content:center; }
    .qty-display { font-size: 13px; font-weight: 600; min-width: 20px; text-align: center; }
    .total-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px; }
    .total-final { font-weight: 700; font-size: 16px; border-top: 2px solid #0e6446; padding-top: 10px; margin-top: 6px; }

    /* Promo pilihan */
    .promo-option {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px;
        border: 1.5px solid #d7d7d7;
        border-radius: 10px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        background: white;
        position: relative;
    }
    .promo-option:hover { border-color: #0e6446; background: #f0fdf4; }
    .promo-option.selected { border-color: #0e6446; background: #f0fdf4; }
    .promo-option input[type="radio"] { width: auto; margin: 0; flex-shrink: 0; accent-color: #0e6446; width: 16px; height: 16px; }
    .promo-option-code { font-size: 13px; font-weight: 700; font-family: monospace; color: #0e6446; }
    .promo-option-desc { font-size: 11px; color: #6b7280; margin-top: 1px; }
    .promo-option-value { margin-left: auto; font-size: 12px; font-weight: 700; color: #0e6446; white-space: nowrap; }

    .promo-none-option {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 14px;
        border: 1.5px solid #d7d7d7;
        border-radius: 10px;
        margin-bottom: 8px;
        cursor: pointer;
        background: white;
        transition: border-color 0.15s;
    }
    .promo-none-option:hover { border-color: #9ca3af; }
    .promo-none-option.selected { border-color: #9ca3af; background: #f9f9f9; }
    .promo-none-option input[type="radio"] { width: 16px; height: 16px; margin: 0; flex-shrink: 0; }

    /* Payment */
    .payment-option { display: flex; align-items: flex-start; gap: 10px; padding: 12px; border: 1px solid #d7d7d7; border-radius: 8px; margin-bottom: 8px; cursor: pointer; }
    .payment-option input[type="radio"] { margin-top: 2px; width: auto; }
    .payment-option.selected { border-color: #0e6446; background: #f0fdf4; }
    .payment-label { font-size: 14px; font-weight: 500; }
    .payment-desc { font-size: 12px; color: #6b7280; }

    .discount-row { color: #16a34a; }
</style>
@endpush

@section('content')

@php
    $subtotalVal = $subtotal;
    $firstPromo  = $promos->first();
    $selectedPromoCode = old('promo_code', request('promo', $firstPromo?->code ?? ''));
@endphp

<div style="margin-bottom:12px">
    <a href="{{ route('customer.menu', $table->qr_token) }}" style="color:#0e6446;font-size:13px;text-decoration:none">
        &larr; Kembali ke Menu
    </a>
</div>

<h2 style="font-size:18px;font-weight:700;margin-bottom:16px">Checkout</h2>

{{-- ── Pesanan ──────────────────────────────────────────────────────── --}}
<div class="card" style="margin-bottom:16px">
    <div class="card-body" style="padding-bottom:0">
        <div style="font-size:14px;font-weight:600;margin-bottom:10px">Pesanan Anda</div>
        @foreach($cart as $menuId => $item)
        <div class="cart-item">
            <div style="flex:1">
                <div class="cart-item-name">{{ $item['name'] }}</div>
                <div class="cart-item-meta">Rp {{ number_format($item['unit_price'], 0, ',', '.') }} / item</div>
                <div class="cart-item-actions">
                    <form action="{{ route('customer.cart.update', $table->qr_token) }}" method="POST" style="display:inline">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menuId }}">
                        <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                        <button type="submit" class="qty-btn">−</button>
                    </form>
                    <span class="qty-display">{{ $item['quantity'] }}</span>
                    <form action="{{ route('customer.cart.update', $table->qr_token) }}" method="POST" style="display:inline">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menuId }}">
                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                        <button type="submit" class="qty-btn">+</button>
                    </form>
                    <form action="{{ route('customer.cart.remove', $table->qr_token) }}" method="POST" style="display:inline;margin-left:4px">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menuId }}">
                        <button type="submit" class="qty-btn" style="color:#dc2626;border-color:#fecaca" title="Hapus">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="cart-item-price">
                Rp {{ number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') }}
            </div>
        </div>
        @endforeach
        <div style="padding:10px 0;display:flex;justify-content:flex-end">
            <form action="{{ route('customer.cart.clear', $table->qr_token) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm"
                    onclick="return confirm('Kosongkan keranjang?')">Kosongkan Keranjang</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Form Checkout ────────────────────────────────────────────────── --}}
<form action="{{ route('customer.checkout.store', $table->qr_token) }}" method="POST" id="checkout-form">
    @csrf

    {{-- Nama & Catatan --}}
    <div class="card" style="margin-bottom:16px">
        <div class="card-body">
            <div class="form-group">
                <label for="customer_name">Nama Pemesan <span style="color:#dc2626">*</span></label>
                <input type="text" id="customer_name" name="customer_name"
                    value="{{ old('customer_name') }}" placeholder="Minimal 3 karakter" required>
                @error('customer_name') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label for="notes">Catatan (opsional)</label>
                <textarea id="notes" name="notes" rows="2"
                    placeholder="Contoh: tanpa gula, extra shot...">{{ old('notes') }}</textarea>
                @error('notes') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- Promo — sebelum metode pembayaran --}}
    @if($promos->count() > 0)
    <div class="card" style="margin-bottom:16px">
        <div class="card-body">
            <div style="font-size:14px;font-weight:600;margin-bottom:12px">Pilih Promo</div>

            {{-- Opsi: tidak pakai promo --}}
            <label class="promo-none-option {{ $selectedPromoCode === '' ? 'selected' : '' }}" id="opt-promo-none">
                <input type="radio" name="promo_code" value=""
                    {{ $selectedPromoCode === '' ? 'checked' : '' }}
                    onchange="onPromoChange(this)">
                <span style="font-size:13px;color:#6b7280">Tidak pakai promo</span>
            </label>

            {{-- Daftar promo --}}
            @foreach($promos as $promo)
            <label class="promo-option {{ $selectedPromoCode === $promo->code ? 'selected' : '' }}"
                   id="opt-promo-{{ $promo->id }}">
                <input type="radio" name="promo_code" value="{{ $promo->code }}"
                    {{ $selectedPromoCode === $promo->code ? 'checked' : '' }}
                    onchange="onPromoChange(this)"
                    data-type="{{ $promo->discount_type }}"
                    data-value="{{ $promo->discount_value }}">
                <div style="flex:1">
                    <div class="promo-option-code">{{ $promo->code }}</div>
                    <div class="promo-option-desc">{{ $promo->description }}</div>
                </div>
                <div class="promo-option-value">
                    @if($promo->discount_type === 'percent')
                        {{ $promo->discount_value }}% OFF
                    @else
                        Rp {{ number_format($promo->discount_value, 0, ',', '.') }} OFF
                    @endif
                </div>
            </label>
            @endforeach

            @error('promo_code') <div class="field-error">{{ $message }}</div> @enderror
        </div>
    </div>
    @else
    {{-- Tidak ada promo, tetap kirim field kosong --}}
    <input type="hidden" name="promo_code" value="">
    @endif

    {{-- Metode Pembayaran --}}
    <div class="card" style="margin-bottom:16px">
        <div class="card-body">
            <div style="font-size:14px;font-weight:600;margin-bottom:12px">Metode Pembayaran</div>
            <label class="payment-option" id="opt-cash">
                <input type="radio" name="payment_method" value="cash"
                    {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}
                    onchange="updatePaymentStyle()">
                <div>
                    <div class="payment-label">Tunai (Cash)</div>
                    <div class="payment-desc">Bayar langsung ke kasir setelah memesan.</div>
                </div>
            </label>
            <label class="payment-option" id="opt-ewallet">
                <input type="radio" name="payment_method" value="ewallet"
                    {{ old('payment_method') === 'ewallet' ? 'checked' : '' }}
                    onchange="updatePaymentStyle()">
                <div>
                    <div class="payment-label">E-Wallet</div>
                    <div class="payment-desc">Bayar via GoPay, OVO, DANA, dan lainnya melalui Midtrans.</div>
                </div>
            </label>
            @error('payment_method') <div class="field-error">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="card" style="margin-bottom:16px">
        <div class="card-body">
            <div style="font-size:14px;font-weight:600;margin-bottom:10px">Ringkasan</div>
            <div class="total-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="total-row discount-row" id="discount-row" style="{{ $selectedPromoCode ? '' : 'display:none' }}">
                <span>Diskon (<span id="discount-label">{{ $selectedPromoCode }}</span>)</span>
                <span id="discount-display">- Rp 0</span>
            </div>
            <div class="total-row total-final">
                <span>Total</span>
                <span id="total-display" style="color:#0e6446">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block" style="margin-bottom:24px">
        Buat Pesanan
    </button>
</form>
@endsection

@push('scripts')
<script>
const SUBTOTAL = {{ $subtotal }};

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function onPromoChange(radio) {
    // Update visual selected state
    document.querySelectorAll('.promo-option, .promo-none-option').forEach(el => {
        el.classList.remove('selected');
    });
    radio.closest('.promo-option, .promo-none-option').classList.add('selected');

    // Hitung diskon
    const code  = radio.value;
    const type  = radio.dataset.type  || '';
    const val   = parseFloat(radio.dataset.value || 0);

    let discount = 0;
    if (code && type === 'percent') {
        discount = SUBTOTAL * (val / 100);
    } else if (code && type === 'fixed') {
        discount = Math.min(val, SUBTOTAL);
    }

    const total = SUBTOTAL - discount;

    // Update ringkasan
    const discountRow = document.getElementById('discount-row');
    if (discount > 0) {
        document.getElementById('discount-label').textContent = code;
        document.getElementById('discount-display').textContent = '- ' + formatRp(discount);
        discountRow.style.display = 'flex';
    } else {
        discountRow.style.display = 'none';
    }
    document.getElementById('total-display').textContent = formatRp(total);
}

function updatePaymentStyle() {
    const cash = document.querySelector('input[value="cash"]');
    document.getElementById('opt-cash').classList.toggle('selected', cash.checked);
    document.getElementById('opt-ewallet').classList.toggle('selected', !cash.checked);
}

// Init
document.addEventListener('DOMContentLoaded', function() {
    updatePaymentStyle();

    // Hitung diskon untuk promo yang sudah terpilih saat load
    const checkedPromo = document.querySelector('input[name="promo_code"]:checked');
    if (checkedPromo && checkedPromo.value) {
        onPromoChange(checkedPromo);
    }
});
</script>
@endpush
