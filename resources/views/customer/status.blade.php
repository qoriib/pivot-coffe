@extends('layouts.customer')

@section('title', 'Status Pesanan — Pivot Caffe')

@push('styles')
<style>
    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    .order-item-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
    .order-item-row:last-child { border-bottom: none; }
    .total-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px; }
    .total-final { font-weight: 700; font-size: 16px; border-top: 2px solid #0e6446; padding-top: 10px; margin-top: 4px; }
</style>
@endpush

@section('content')
<div style="text-align:center;padding:20px 0 16px">
    <div style="font-size:18px;font-weight:700;margin-bottom:8px">Status Pesanan</div>
    <div style="font-size:12px;color:#6b7280;font-family:monospace">{{ $order->transaction_id }}</div>
</div>

{{-- Status Card --}}
<div class="card" style="margin-bottom:16px">
    <div class="card-body" style="text-align:center;padding:24px">
        @if($order->order_status === 'menunggu')
            <div class="status-badge" style="background:#fef3c7;color:#92400e">Menunggu Konfirmasi</div>
            <p style="font-size:13px;color:#6b7280;margin-top:10px">Pesanan Anda sedang menunggu dikonfirmasi oleh staf.</p>
        @elseif($order->order_status === 'diproses')
            <div class="status-badge" style="background:#dbeafe;color:#1e40af">Sedang Diproses</div>
            <p style="font-size:13px;color:#6b7280;margin-top:10px">Pesanan Anda sedang disiapkan.</p>
        @elseif($order->order_status === 'selesai')
            <div class="status-badge" style="background:#dcfce7;color:#166534">Selesai</div>
            <p style="font-size:13px;color:#6b7280;margin-top:10px">Pesanan Anda telah selesai. Selamat menikmati!</p>
        @elseif($order->order_status === 'dibatalkan')
            <div class="status-badge" style="background:#fee2e2;color:#991b1b">Dibatalkan</div>
            <p style="font-size:13px;color:#6b7280;margin-top:10px">Pesanan ini telah dibatalkan.</p>
        @endif

        <div style="margin-top:12px;font-size:13px">
            Pembayaran:
            @if($order->payment_status === 'paid')
                <span style="color:#16a34a;font-weight:600">Lunas</span>
            @elseif($order->payment_status === 'failed')
                <span style="color:#dc2626;font-weight:600">Gagal</span>
            @else
                <span style="color:#d97706;font-weight:600">Belum Dibayar</span>
            @endif
        </div>
    </div>
</div>

{{-- Order Info --}}
<div class="card" style="margin-bottom:16px">
    <div class="card-body">
        <div style="font-size:14px;font-weight:600;margin-bottom:10px">Detail Pesanan</div>
        <div style="font-size:13px;color:#6b7280;margin-bottom:4px">Meja {{ $order->table->number }} &bull; {{ $order->customer_name }}</div>
        <div style="font-size:13px;color:#6b7280;margin-bottom:12px">
            {{ $order->payment_method === 'cash' ? 'Tunai' : 'E-Wallet' }} &bull;
            {{ $order->created_at->format('d/m/Y H:i') }}
        </div>

        @foreach($order->items as $item)
        <div class="order-item-row">
            <span>{{ $item->quantity }}x {{ $item->menu->name }}</span>
            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
        @endforeach

        <div style="margin-top:12px">
            <div class="total-row"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
            @if($order->discount > 0)
            <div class="total-row" style="color:#16a34a"><span>Diskon</span><span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span></div>
            @endif
            <div class="total-row total-final"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
        </div>

        @if($order->notes)
        <div style="margin-top:12px;font-size:13px;background:#f5f5f5;padding:10px;border-radius:6px">
            Catatan: {{ $order->notes }}
        </div>
        @endif
    </div>
</div>

{{-- Actions --}}
<div style="display:flex;flex-direction:column;gap:10px;margin-bottom:24px">
    @if($order->order_status === 'menunggu')
    <form action="{{ route('customer.cancel', $order->table->qr_token) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger btn-block"
            onclick="return confirm('Batalkan pesanan ini?')">Batalkan Pesanan</button>
    </form>
    @endif

    @if($order->order_status === 'selesai' && !$order->feedback)
    <a href="{{ route('customer.feedback', $order->transaction_id) }}" class="btn btn-primary btn-block">
        Beri Rating
    </a>
    @endif

    @if($order->order_status === 'selesai' && $order->feedback)
    <div style="text-align:center;font-size:13px;color:#6b7280">
        Anda sudah memberikan rating untuk pesanan ini.
    </div>
    @endif

    <a href="{{ route('customer.menu', $order->table->qr_token) }}" class="btn btn-secondary btn-block">
        Pesan Lagi
    </a>
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh if order is still active
    @if(in_array($order->order_status, ['menunggu', 'diproses']))
    setTimeout(function() { location.reload(); }, 10000);
    @endif
</script>
@endpush
