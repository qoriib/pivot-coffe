@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
<div style="display:flex;gap:16px;flex-wrap:wrap;align-items:flex-start">
    <div style="flex:1;min-width:300px">
        <div class="card" style="margin-bottom:16px">
            <div class="card-header">
                <div class="card-title">Informasi Pesanan</div>
                <a href="{{ route('admin.orders.print', $order) }}" class="btn btn-secondary btn-sm" target="_blank">Cetak Nota</a>
            </div>
            <div class="card-body">
                <table style="width:100%">
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0;width:140px">ID Transaksi</td><td style="font-size:12px;font-family:monospace">{{ $order->transaction_id }}</td></tr>
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0">Meja</td><td>Meja {{ $order->table->number }}</td></tr>
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0">Pelanggan</td><td>{{ $order->customer_name }}</td></tr>
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0">Pembayaran</td><td>{{ $order->payment_method === 'cash' ? 'Tunai' : 'E-Wallet' }}</td></tr>
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0">Status Bayar</td>
                        <td>
                            @if($order->payment_status === 'paid') <span class="badge badge-success">Lunas</span>
                            @elseif($order->payment_status === 'failed') <span class="badge badge-danger">Gagal</span>
                            @else <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0">Status Pesanan</td>
                        <td>
                            @if($order->order_status === 'selesai') <span class="badge badge-success">Selesai</span>
                            @elseif($order->order_status === 'dibatalkan') <span class="badge badge-danger">Dibatalkan</span>
                            @elseif($order->order_status === 'diproses') <span class="badge badge-info">Diproses</span>
                            @else <span class="badge badge-warning">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0">Tanggal</td><td>{{ $order->created_at->format('d/m/Y H:i') }}</td></tr>
                    @if($order->notes)
                    <tr><td style="color:#6b7280;font-size:13px;padding:4px 0">Catatan</td><td>{{ $order->notes }}</td></tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><div class="card-title">Item Pesanan</div></div>
            <div class="table-wrap">
                <table class="sortable">
                    <thead>
                        <tr><th>Menu</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->menu->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3" style="text-align:right;font-weight:500">Subtotal</td><td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td></tr>
                        @if($order->discount > 0)
                        <tr><td colspan="3" style="text-align:right;font-weight:500;color:#16a34a">Diskon</td><td style="color:#16a34a">- Rp {{ number_format($order->discount, 0, ',', '.') }}</td></tr>
                        @endif
                        <tr><td colspan="3" style="text-align:right;font-weight:700">Total</td><td style="font-weight:700">Rp {{ number_format($order->total, 0, ',', '.') }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div style="width:280px">
        @if(!in_array($order->order_status, ['selesai', 'dibatalkan']))
        <div class="card" style="margin-bottom:16px">
            <div class="card-header"><div class="card-title">Update Status</div></div>
            <div class="card-body">

                {{-- Konfirmasi bayar --}}
                @if($order->payment_status === 'pending')
                    @if($order->payment_method === 'cash')
                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" style="margin-bottom:12px">
                        @csrf
                        <div class="form-group">
                            <label>Uang Diterima</label>
                            <input type="number" name="cash_received" id="cash_received" min="0" step="100" placeholder="Contoh: 100000" value="{{ old('cash_received') }}">
                            @error('cash_received')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div style="font-size:12px;color:#6b7280;margin:-6px 0 12px">
                            Kembalian: <strong id="cash_change">Rp 0</strong>
                        </div>
                        <button type="submit" class="btn btn-success" style="width:100%">
                            Konfirmasi Pembayaran Tunai
                        </button>
                    </form>
                    <div style="font-size:11px;color:#6b7280;margin-bottom:14px;text-align:center">
                        Isi uang yang diterima, pastikan kembalian sesuai.
                        Status pesanan otomatis jadi Diproses.
                    </div>
                    @else
                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" style="margin-bottom:12px">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width:100%">
                            Konfirmasi Pembayaran E-Wallet
                        </button>
                    </form>
                    <div style="font-size:11px;color:#6b7280;margin-bottom:14px;text-align:center">
                        Klik setelah pelanggan menunjukkan bukti transfer e-wallet.
                        Status pesanan otomatis jadi Diproses.
                    </div>
                    @endif
                @endif

                {{-- Update status pesanan — hanya tampil kalau sudah bayar --}}
                @if($order->payment_status === 'paid')
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Status Pesanan</label>
                        <select name="order_status">
                            <option value="diproses" {{ $order->order_status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai">Selesai</option>
                            @if($order->payment_method === 'cash')
                                <option value="dibatalkan">Dibatalkan</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%">Simpan</button>
                </form>
                @else
                <div style="font-size:12px;color:#6b7280;text-align:center;padding:8px;background:#fef3c7;border-radius:6px">
                    Konfirmasi pembayaran terlebih dahulu sebelum memproses pesanan.
                </div>
                @endif

            </div>
        </div>
        @endif

        @if($order->feedback)
        <div class="card">
            <div class="card-header"><div class="card-title">Feedback Pelanggan</div></div>
            <div class="card-body">
                <div style="font-size:20px;margin-bottom:8px">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color:{{ $i <= $order->feedback->rating ? '#d97706' : '#d7d7d7' }}">&#9733;</span>
                    @endfor
                </div>
                @if($order->feedback->comment)
                    <p style="font-size:13px;color:#6b7280">{{ $order->feedback->comment }}</p>
                @endif
            </div>
        </div>
        @endif

        <div style="margin-top:12px">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary" style="width:100%">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var input = document.getElementById('cash_received');
        if (!input) return;
        var changeEl = document.getElementById('cash_change');
        var total = {{ (int) $order->total }};

        function formatRupiah(value) {
            return 'Rp ' + value.toLocaleString('id-ID');
        }

        function updateChange() {
            var received = parseFloat(input.value || '0');
            var change = received - total;
            if (isNaN(change) || change < 0) {
                change = 0;
            }
            changeEl.textContent = formatRupiah(Math.floor(change));
        }

        input.addEventListener('input', updateChange);
        updateChange();
    })();
</script>
@endpush
