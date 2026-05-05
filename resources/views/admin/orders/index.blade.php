@extends('layouts.admin')
@section('title', 'Riwayat Pesanan')
@section('page-title', 'Riwayat Pesanan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Semua Pesanan</div>
    </div>
    <div class="card-body" style="padding-bottom:0;border-bottom:1px solid #d7d7d7">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;padding-bottom:16px">
            <div>
                <label style="font-size:12px">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" style="width:auto">
            </div>
            <div>
                <label style="font-size:12px">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" style="width:auto">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if(request('start_date') || request('end_date'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Meja</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status Bayar</th>
                    <th>Status Pesanan</th>
                    <th>Tanggal</th>
                    <th class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="font-size:11px;font-family:monospace">{{ $order->transaction_id }}</td>
                    <td>Meja {{ $order->table->number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ $order->payment_method === 'cash' ? 'Tunai' : 'E-Wallet' }}</td>
                    <td>
                        @if($order->payment_status === 'paid')
                            <span class="badge badge-success">Lunas</span>
                        @elseif($order->payment_status === 'failed')
                            <span class="badge badge-danger">Gagal</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($order->order_status === 'selesai')
                            <span class="badge badge-success">Selesai</span>
                        @elseif($order->order_status === 'dibatalkan')
                            <span class="badge badge-danger">Dibatalkan</span>
                        @elseif($order->order_status === 'diproses')
                            <span class="badge badge-info">Diproses</span>
                        @else
                            <span class="badge badge-warning">Menunggu</span>
                        @endif
                    </td>
                    <td style="font-size:12px">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">Detail</a>
                        <a href="{{ route('admin.orders.print', $order) }}" class="btn btn-secondary btn-sm" target="_blank">Cetak</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;color:#6b7280;padding:32px">Tidak ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $orders->links() }}</div>
</div>
@endsection
