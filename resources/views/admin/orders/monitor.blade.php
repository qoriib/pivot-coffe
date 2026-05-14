@extends('layouts.admin')

@section('title', 'Monitor Pesanan')
@section('page-title', 'Monitor Pesanan')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
    <p style="font-size:13px;color:#6b7280">Auto-refresh setiap 10 detik. Menampilkan pesanan aktif.</p>
    <span style="font-size:12px;color:#6b7280" id="last-refresh">Terakhir diperbarui: baru saja</span>
</div>

@if($orders->isEmpty())
    <div class="card">
        <div class="card-body" style="text-align:center;padding:40px;color:#6b7280">
            Tidak ada pesanan aktif saat ini.
        </div>
    </div>
@else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px">
        @foreach($orders as $order)
        @php
            $belumBayar = $order->payment_status === 'pending';
            $sudahBayar = $order->payment_status === 'paid';
            $tunai      = $order->payment_method === 'cash';
        @endphp
        <div class="card">
            {{-- Header --}}
            <div class="card-header" style="background:{{ $order->order_status === 'menunggu' ? '#fef3c7' : '#dbeafe' }}">
                <div>
                    <div style="font-weight:600;font-size:14px">Meja {{ $order->table->number }} — {{ $order->customer_name }}</div>
                    <div style="font-size:12px;color:#6b7280">{{ $order->transaction_id }}</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px">
                    <span class="badge {{ $order->order_status === 'menunggu' ? 'badge-warning' : 'badge-info' }}">
                        {{ $order->order_status === 'menunggu' ? 'Menunggu' : 'Diproses' }}
                    </span>
                    <span class="badge {{ $sudahBayar ? 'badge-success' : 'badge-danger' }}">
                        {{ $sudahBayar ? 'Lunas' : 'Belum Bayar' }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                {{-- Items --}}
                <div style="margin-bottom:12px">
                    @foreach($order->items as $item)
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:3px 0">
                        <span>{{ $item->quantity }}x {{ $item->menu->name }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div style="border-top:1px solid #d7d7d7;padding-top:10px;display:flex;justify-content:space-between;font-weight:600">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>

                <div style="margin-top:6px;font-size:12px;color:#6b7280">
                    {{ $order->created_at->diffForHumans() }} &bull;
                    {{ $tunai ? 'Tunai' : 'E-Wallet' }}
                </div>

                @if($order->notes)
                <div style="margin-top:8px;font-size:12px;background:#f5f5f5;padding:8px;border-radius:4px">
                    Catatan: {{ $order->notes }}
                </div>
                @endif

                {{-- Tombol aksi --}}
                <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap">

                    {{-- BELUM BAYAR --}}
                    @if($belumBayar && in_array($order->order_status, ['menunggu', 'diproses']))
                        @if($tunai)
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-success btn-sm">Proses Bayar Tunai</a>
                        @else
                            <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    Konfirmasi Bayar
                                </button>
                            </form>
                        @endif
                    @endif

                    {{-- SUDAH BAYAR & DIPROSES: tampilkan tombol selesai --}}
                    @if($sudahBayar && $order->order_status === 'diproses')
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_status" value="selesai">
                        <button type="submit" class="btn btn-primary btn-sm">Selesai</button>
                    </form>
                    @endif

                    {{-- Batalkan --}}
                    @if(in_array($order->order_status, ['menunggu', 'diproses']) && $order->payment_method === 'cash')
                    <button type="button" class="btn btn-danger btn-sm"
                        onclick="batalkanPesanan('{{ route('admin.orders.status', $order) }}', '{{ $order->transaction_id }}')">
                        Batalkan
                    </button>
                    @endif

                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Modal Batalkan Pesanan --}}
<div class="modal-backdrop" id="modal-batalkan">
    <div class="modal modal-sm">
        <div class="modal-body" style="padding:28px 24px 20px">
            <div style="width:56px;height:56px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:24px">&#9888;</div>
            <div style="text-align:center;font-size:17px;font-weight:700;margin-bottom:6px">Batalkan Pesanan?</div>
            <div style="text-align:center;font-size:13px;color:#6b7280;margin-bottom:20px;line-height:1.6" id="batalkan-desc">
                Pesanan akan ditandai sebagai dibatalkan.
            </div>
            <div style="display:flex;gap:10px;justify-content:center">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-batalkan')">Batal</button>
                <form id="batalkan-form" method="POST" style="display:inline">
                    @csrf
                    <input type="hidden" name="order_status" value="dibatalkan">
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    setTimeout(function() { location.reload(); }, 10000);
    document.getElementById('last-refresh').textContent = 'Terakhir diperbarui: ' + new Date().toLocaleTimeString('id-ID');

    function batalkanPesanan(action, trxId) {
        document.getElementById('batalkan-desc').innerHTML =
            'Apakah Anda yakin ingin membatalkan pesanan <strong>' + trxId + '</strong>?<br>' +
            '<span style="color:#dc2626;font-size:12px">Tindakan ini tidak dapat dibatalkan.</span>';
        document.getElementById('batalkan-form').action = action;
        openModal('modal-batalkan');
    }
</script>
@endpush
