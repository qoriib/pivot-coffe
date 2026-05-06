@extends('layouts.customer')

@section('title', 'Checkout — Pivot Caffe')

@push('styles')
<style>
    .checkout-container {
        max-width: 1000px;
        margin: 0 auto;
        padding-top: 120px;
        padding-bottom: 80px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }

    @media (min-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1.6fr 1fr;
            align-items: flex-start;
        }
    }

    .checkout-card {
        background: white;
        border-radius: 25px;
        padding: 30px;
        box-shadow: var(--shadow);
        border: var(--border);
        margin-bottom: 30px;
    }

    .checkout-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .checkout-card-title i {
        font-size: 1.2rem;
        color: var(--accent);
    }

    /* Items Table */
    .order-items-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 20px;
    }

    .order-item-row {
        display: flex;
        gap: 15px;
        align-items: center;
        padding-bottom: 20px;
        border-bottom: 1px dashed rgba(0,0,0,0.1);
    }

    .order-item-row:last-child {
        border-bottom: none;
    }

    .order-item-info {
        flex: 1;
    }

    .order-item-name {
        font-weight: 700;
        color: var(--primary);
        font-size: 15px;
        margin-bottom: 5px;
    }

    .order-item-meta {
        font-size: 12px;
        color: var(--text-light);
    }

    .order-item-qty {
        font-weight: 600;
        background: var(--bg);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 12px;
    }

    .order-item-total {
        font-weight: 700;
        color: var(--primary);
        font-size: 15px;
        min-width: 100px;
        text-align: right;
    }

    /* Form Styles */
    .form-group-p {
        margin-bottom: 25px;
    }

    .form-label-p {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: var(--text);
        margin-bottom: 10px;
    }

    .form-input-p {
        width: 100%;
        padding: 15px 20px;
        border-radius: 15px;
        border: var(--border);
        background: var(--bg);
        font-family: inherit;
        font-size: 15px;
        transition: all 0.3s;
    }

    .form-input-p:focus {
        outline: none;
        border-color: var(--accent);
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    /* Promo Options */
    .promo-selection {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .promo-opt {
        position: relative;
        cursor: pointer;
    }

    .promo-opt input {
        position: absolute;
        opacity: 0;
    }

    .promo-opt-box {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border-radius: 15px;
        border: 2px solid #f0f0f0;
        transition: all 0.3s;
        background: white;
    }

    .promo-opt input:checked + .promo-opt-box {
        border-color: var(--primary);
        background: rgba(27, 67, 50, 0.02);
    }

    .promo-radio-ui {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #ddd;
        position: relative;
        flex-shrink: 0;
    }

    .promo-opt input:checked + .promo-opt-box .promo-radio-ui {
        border-color: var(--primary);
    }

    .promo-opt input:checked + .promo-opt-box .promo-radio-ui::after {
        content: '';
        position: absolute;
        inset: 4px;
        background: var(--primary);
        border-radius: 50%;
    }

    .promo-info {
        flex: 1;
    }

    .promo-code-name {
        font-weight: 700;
        font-size: 14px;
        color: var(--primary);
        margin-bottom: 2px;
    }

    .promo-code-desc {
        font-size: 11px;
        color: var(--text-light);
    }

    .promo-val-badge {
        background: var(--accent-light);
        color: var(--primary-dark);
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
    }

    /* Payment Methods */
    .payment-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .pay-opt {
        position: relative;
        cursor: pointer;
    }

    .pay-opt input {
        position: absolute;
        opacity: 0;
    }

    .pay-opt-box {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border-radius: 15px;
        border: 2px solid #f0f0f0;
        transition: all 0.3s;
        background: white;
    }

    .pay-opt input:checked + .pay-opt-box {
        border-color: var(--primary);
        background: rgba(27, 67, 50, 0.02);
    }

    .pay-icon {
        width: 45px;
        height: 45px;
        background: var(--bg);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary);
    }

    .pay-opt input:checked + .pay-opt-box .pay-icon {
        background: var(--primary);
        color: white;
    }

    /* Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .summary-total {
        margin-top: 20px;
        padding-top: 20px;
        border-top: var(--border);
        display: flex;
        justify-content: space-between;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
    }

    .back-to-menu {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-light);
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 30px;
        transition: color 0.3s;
    }

    .back-to-menu:hover {
        color: var(--primary);
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    
    <a href="{{ route('customer.menu', $table->qr_token) }}" class="back-to-menu">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Menu</span>
    </a>

    <h1 class="font-serif" style="margin-bottom: 40px; font-size: 2.5rem; color: var(--primary);">Konfirmasi Pesanan</h1>

    <div class="checkout-grid">
        <div class="checkout-left">
            
            {{-- Form Checkout --}}
            <form action="{{ route('customer.checkout.store', $table->qr_token) }}" method="POST" id="checkout-form">
                @csrf

                <div class="checkout-card fade-in-up">
                    <h2 class="checkout-card-title">Data Diri</h2>
                    
                    <div class="form-group-p">
                        <label class="form-label-p" for="customer_name">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" class="form-input-p"
                            value="{{ old('customer_name') }}" placeholder="Contoh: Budi Santoso" required>
                        @error('customer_name') <div style="color:var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group-p" style="margin-bottom:0">
                        <label class="form-label-p" for="notes">Catatan Pesanan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3" class="form-input-p" style="border-radius: 20px; resize: none;"
                            placeholder="Contoh: Es sedikit, kopi dipisah, dll...">{{ old('notes') }}</textarea>
                        @error('notes') <div style="color:var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                @if($promos->count() > 0)
                <div class="checkout-card fade-in-up">
                    <h2 class="checkout-card-title">Pakai Promo</h2>
                    
                    <div class="promo-selection">
                        {{-- No Promo --}}
                        <label class="promo-opt">
                            <input type="radio" name="promo_code" value="" 
                                {{ request('promo') ? '' : 'checked' }} onchange="onPromoChange(this)">
                            <div class="promo-opt-box">
                                <div class="promo-radio-ui"></div>
                                <div class="promo-info">
                                    <div class="promo-code-name">Tidak Pakai Promo</div>
                                </div>
                            </div>
                        </label>

                        @foreach($promos as $promo)
                        <label class="promo-opt">
                            <input type="radio" name="promo_code" value="{{ $promo->code }}"
                                {{ request('promo') === $promo->code ? 'checked' : '' }}
                                data-type="{{ $promo->discount_type }}"
                                data-value="{{ $promo->discount_value }}"
                                onchange="onPromoChange(this)">
                            <div class="promo-opt-box">
                                <div class="promo-radio-ui"></div>
                                <div class="promo-info">
                                    <div class="promo-code-name">{{ $promo->code }}</div>
                                    <div class="promo-code-desc">{{ $promo->description }}</div>
                                </div>
                                <div class="promo-val-badge">
                                    {{ $promo->discount_type === 'percent' ? $promo->discount_value.'%' : 'Rp '.number_format($promo->discount_value,0,',','.') }} OFF
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @else
                <input type="hidden" name="promo_code" value="">
                @endif

                <div class="checkout-card fade-in-up">
                    <h2 class="checkout-card-title">Pembayaran</h2>
                    
                    <div class="payment-grid">
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                            <div class="pay-opt-box">
                                <div class="pay-icon"><i class="fas fa-money-bill-wave"></i></div>
                                <div class="pay-info">
                                    <div style="font-weight: 700; color: var(--primary);">Tunai (Kasir)</div>
                                    <div style="font-size: 12px; color: var(--text-light);">Bayar di kasir setelah pesanan dibuat</div>
                                </div>
                            </div>
                        </label>

                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="ewallet" {{ old('payment_method') === 'ewallet' ? 'checked' : '' }}>
                            <div class="pay-opt-box">
                                <div class="pay-icon"><i class="fas fa-wallet"></i></div>
                                <div class="pay-info">
                                    <div style="font-weight: 700; color: var(--primary);">E-Wallet / QRIS</div>
                                    <div style="font-size: 12px; color: var(--text-light);">Gopay, OVO, Dana, LinkAja, QRIS</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('payment_method') <div style="color:var(--danger); font-size: 12px; margin-top: 10px;">{{ $message }}</div> @enderror
                </div>
            </form>
        </div>

        <div class="checkout-right">
            <div class="checkout-card fade-in-up" style="position: sticky; top: 100px;">
                <h2 class="checkout-card-title">Ringkasan</h2>
                
                <div class="order-items-list">
                    @foreach($cart as $menuId => $item)
                    <div class="order-item-row">
                        <div class="order-item-info">
                            <div class="order-item-name">{{ $item['name'] }}</div>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span class="order-item-qty">{{ $item['quantity'] }}x</span>
                                <span class="order-item-meta">@ Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="order-item-total">Rp {{ number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top: 25px;">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-row" id="discount-row" style="color: var(--success); display: none;">
                        <span>Diskon (<span id="discount-label"></span>)</span>
                        <span id="discount-display">- Rp 0</span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span id="total-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-block" style="margin-top: 30px; padding: 18px;" onclick="document.getElementById('checkout-form').submit()">
                    Konfirmasi & Pesan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const SUBTOTAL = {{ $subtotal }};

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function onPromoChange(radio) {
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

// Initial check on load
document.addEventListener('DOMContentLoaded', function() {
    const checkedPromo = document.querySelector('input[name="promo_code"]:checked');
    if (checkedPromo && checkedPromo.value) {
        onPromoChange(checkedPromo);
    }
});
</script>
@endpush
