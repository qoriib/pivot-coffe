@extends('layouts.customer')

@section('title', 'Status Pesanan — Pivot Caffe')

@push('styles')
<style>
    .status-container {
        max-width: 700px;
        margin: 0 auto;
        padding-top: 120px;
        padding-bottom: 80px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .status-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: var(--shadow);
        border: var(--border);
        text-align: center;
        margin-bottom: 30px;
    }

    .status-icon-box {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .status-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .status-desc {
        color: var(--text-light);
        font-size: 14px;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .order-details-card {
        background: white;
        border-radius: 25px;
        padding: 30px;
        box-shadow: var(--shadow);
        border: var(--border);
        margin-bottom: 30px;
    }

    .details-title {
        font-weight: 700;
        font-size: 16px;
        color: var(--primary);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: var(--border);
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .item-row span:first-child {
        color: var(--text-light);
    }

    .item-row span:last-child {
        font-weight: 600;
        color: var(--primary);
    }

    .status-badge-p {
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .badge-waiting { background: #fffbeb; color: #d97706; }
    .badge-processing { background: #eff6ff; color: #2563eb; }
    .badge-success { background: #f0fdf4; color: #166534; }
    .badge-danger { background: #fef2f2; color: #dc2626; }
</style>
@endpush

@section('content')
<div class="status-container">
    
    <div style="text-align:center; margin-bottom: 40px;">
        <h1 class="font-serif" style="color: var(--primary); font-size: 2.5rem; margin-bottom: 5px;">Terima Kasih</h1>
        <p style="color: var(--text-light); font-size: 14px;">Nomor Pesanan: <span style="font-family: monospace; font-weight: 700;">{{ $order->transaction_id }}</span></p>
    </div>

    <div class="status-card fade-in-up">
        @if($order->order_status === 'menunggu')
            <div class="status-icon-box" style="background: #fffbeb; color: #d97706;"><i class="fas fa-clock"></i></div>
            <h2 class="status-title">Menunggu Konfirmasi</h2>
            <p class="status-desc">Pesanan Anda telah diterima dan sedang menunggu dikonfirmasi oleh staf kami.</p>
        @elseif($order->order_status === 'diproses')
            <div class="status-icon-box" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-coffee"></i></div>
            <h2 class="status-title">Sedang Diproses</h2>
            <p class="status-desc">Barista kami sedang meracik pesanan terbaik untuk Anda. Mohon tunggu sebentar ya!</p>
        @elseif($order->order_status === 'selesai')
            <div class="status-icon-box" style="background: #f0fdf4; color: #166534;"><i class="fas fa-check-circle"></i></div>
            <h2 class="status-title">Pesanan Selesai</h2>
            <p class="status-desc">Pesanan Anda telah diantarkan. Selamat menikmati hidangan spesial dari Pivot Caffe!</p>
        @elseif($order->order_status === 'dibatalkan')
            <div class="status-icon-box" style="background: #fef2f2; color: #dc2626;"><i class="fas fa-times-circle"></i></div>
            <h2 class="status-title">Pesanan Dibatalkan</h2>
            <p class="status-desc">Mohon maaf, pesanan Anda telah dibatalkan. Silakan hubungi staf jika ada kendala.</p>
        @endif

        <div style="display: flex; justify-content: center; gap: 15px; margin-top: 10px;">
            <div class="status-badge-p {{ $order->payment_status === 'paid' ? 'badge-success' : ($order->payment_status === 'failed' ? 'badge-danger' : 'badge-waiting') }}">
                {{ $order->payment_status === 'paid' ? 'Sudah Lunas' : ($order->payment_status === 'failed' ? 'Pembayaran Gagal' : 'Belum Dibayar') }}
            </div>
        </div>
    </div>

    <div class="order-details-card fade-in-up">
        <h3 class="details-title">Detail Pesanan</h3>
        <div class="item-row"><span>Meja</span><span>{{ $order->table->number }}</span></div>
        <div class="item-row"><span>Nama Pemesan</span><span>{{ $order->customer_name }}</span></div>
        <div class="item-row"><span>Metode Bayar</span><span>{{ $order->payment_method === 'cash' ? 'Tunai (Kasir)' : 'E-Wallet / QRIS' }}</span></div>
        <div class="item-row"><span>Waktu Pesan</span><span>{{ $order->created_at->format('d M Y, H:i') }}</span></div>
        
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px dashed #eee;">
            @foreach($order->items as $item)
            <div class="item-row">
                <span>{{ $item->quantity }}x {{ $item->menu->name }}</span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 15px; padding-top: 15px; border-top: var(--border);">
            <div class="item-row" style="font-size: 1.1rem; font-weight: 700;">
                <span style="color: var(--primary) !important;">Total Pembayaran</span>
                <span style="color: var(--primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->notes)
        <div style="margin-top: 20px; padding: 15px; background: var(--bg); border-radius: 15px; font-size: 13px; color: var(--text-light); font-style: italic;">
            <strong>Catatan:</strong> "{{ $order->notes }}"
        </div>
        @endif
    </div>

    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px;">
        @if($order->order_status === 'menunggu')
        <form action="{{ route('customer.cancel', $order->table->qr_token) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-block" style="background: #fff; color: var(--danger); border: 1px solid var(--danger); padding: 15px;"
                onclick="return confirm('Batalkan pesanan ini?')">Batalkan Pesanan</button>
        </form>
        @endif

        @if($order->order_status === 'selesai' && !$order->feedback)
        <a href="{{ route('customer.feedback', $order->transaction_id) }}" class="btn btn-primary btn-block" style="padding: 18px;">
            <i class="fas fa-star" style="margin-right: 10px;"></i> Beri Penilaian & Saran
        </a>
        @endif

        <a href="{{ route('customer.menu', $order->table->qr_token) }}" class="btn btn-accent btn-block" style="padding: 18px;">
            Pesan Menu Lain
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh if order is still active
    @if(in_array($order->order_status, ['menunggu', 'diproses']))
    setTimeout(function() { location.reload(); }, 15000);
    @endif
</script>
@endpush
