@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Stat Cards Real-time ─────────────────────────────────────────── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Pesanan Aktif</div>
        <div class="stat-value">{{ $activeOrders }}</div>
        <div style="font-size:12px;color:#6b7280;margin-top:4px">Menunggu & Diproses</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pembayaran Pending</div>
        <div class="stat-value">{{ $pendingPayments }}</div>
        <div style="font-size:12px;color:#6b7280;margin-top:4px">Belum dikonfirmasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Panggilan Pelayan</div>
        <div class="stat-value" style="{{ $pendingWaiterCalls > 0 ? 'color:#dc2626' : '' }}">{{ $pendingWaiterCalls }}</div>
        <div style="font-size:12px;color:#6b7280;margin-top:4px">Menunggu respons</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pemasukan Hari Ini</div>
        <div class="stat-value" style="font-size:22px">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
        <div style="font-size:12px;color:#6b7280;margin-top:4px">Order lunas hari ini</div>
    </div>
</div>

{{-- ── Ringkasan Pemasukan ──────────────────────────────────────────── --}}
<div class="card" style="margin-bottom:24px">
    <div class="card-header">
        <div class="card-title">Ringkasan Pemasukan</div>
        <div style="display:flex;gap:6px;flex-wrap:wrap;align-items:center">
            <a href="{{ route('admin.dashboard', ['period' => '1']) }}"
               class="btn btn-sm {{ $period === '1' ? 'btn-primary' : 'btn-secondary' }}">Hari Ini</a>
            <a href="{{ route('admin.dashboard', ['period' => '7']) }}"
               class="btn btn-sm {{ $period === '7' ? 'btn-primary' : 'btn-secondary' }}">7 Hari</a>
            <a href="{{ route('admin.dashboard', ['period' => '30']) }}"
               class="btn btn-sm {{ $period === '30' ? 'btn-primary' : 'btn-secondary' }}">30 Hari</a>
            <button type="button" class="btn btn-sm {{ $period === 'custom' ? 'btn-primary' : 'btn-secondary' }}"
                onclick="toggleCustomDate()">Custom</button>
        </div>
    </div>
    <div id="custom-date-form" style="{{ $period === 'custom' ? '' : 'display:none' }};padding:12px 20px;border-bottom:1px solid #d7d7d7;background:#fafafa">
        <form method="GET" action="{{ route('admin.dashboard') }}" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap">
            <input type="hidden" name="period" value="custom">
            <div>
                <label style="font-size:12px;display:block;margin-bottom:4px">Dari Tanggal</label>
                <input type="date" name="start_date"
                    value="{{ $period === 'custom' ? $startDate->format('Y-m-d') : '' }}"
                    style="width:auto;font-size:13px;padding:6px 10px">
            </div>
            <div>
                <label style="font-size:12px;display:block;margin-bottom:4px">Sampai Tanggal</label>
                <input type="date" name="end_date"
                    value="{{ $period === 'custom' ? $endDate->format('Y-m-d') : '' }}"
                    style="width:auto;font-size:13px;padding:6px 10px">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
        </form>
    </div>
    <div style="padding:10px 20px 0;font-size:12px;color:#6b7280">
        Menampilkan data: <strong>
            @if($period === '1') Hari ini
            @elseif($period === '7') 7 hari terakhir
            @elseif($period === 'custom') {{ $startDate->format('d/m/Y') }} — {{ $endDate->format('d/m/Y') }}
            @else 30 hari terakhir
            @endif
        </strong>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px">
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:18px">
                <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:#16a34a;margin-bottom:6px">Total Pemasukan</div>
                <div style="font-size:26px;font-weight:700;color:#0e6446;line-height:1.2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div style="font-size:12px;color:#6b7280;margin-top:4px">Dari order lunas</div>
            </div>
            <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:18px">
                <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:#0284c7;margin-bottom:6px">Total Transaksi</div>
                <div style="font-size:26px;font-weight:700;color:#0369a1;line-height:1.2">{{ number_format($totalOrders, 0, ',', '.') }}</div>
                <div style="font-size:12px;color:#6b7280;margin-top:4px">Pesanan selesai dibayar</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Status Meja ──────────────────────────────────────────────────── --}}
<div class="card" style="margin-bottom:24px">
    <div class="card-header">
        <div class="card-title">Status Meja</div>
        <span style="font-size:12px;color:#6b7280">Auto-refresh 10 detik</span>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th>No. Meja</th>
                    <th>Status Meja</th>
                    <th>Pelanggan</th>
                    <th>Status Pesanan</th>
                    <th>Status Bayar</th>
                    <th>Total</th>
                    <th class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tableStatuses as $table)
                @php $order = $table->orders->first(); @endphp
                <tr>
                    <td style="font-weight:700">Meja {{ $table->number }}</td>
                    <td>
                        @if($order)
                            <span class="badge badge-warning">Terisi</span>
                        @else
                            <span class="badge badge-success">Kosong</span>
                        @endif
                    </td>
                    <td>{{ $order?->customer_name ?? '—' }}</td>
                    <td>
                        @if($order)
                            @if($order->order_status === 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($order->order_status === 'diproses')
                                <span class="badge badge-info">Diproses</span>
                            @endif
                        @else
                            <span style="color:#9ca3af;font-size:12px">—</span>
                        @endif
                    </td>
                    <td>
                        @if($order)
                            @if($order->payment_status === 'paid')
                                <span class="badge badge-success">Lunas</span>
                            @else
                                <span class="badge badge-danger">Belum Bayar</span>
                            @endif
                        @else
                            <span style="color:#9ca3af;font-size:12px">—</span>
                        @endif
                    </td>
                    <td>
                        @if($order)
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        @else
                            <span style="color:#9ca3af;font-size:12px">—</span>
                        @endif
                    </td>
                    <td>
                        @if($order)
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">Detail</a>
                        @else
                            <span style="color:#9ca3af;font-size:12px">Tidak ada pesanan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ── Waiter Calls Aktif ───────────────────────────────────────────── --}}
@if($waiterCalls->count() > 0)
<div class="card" style="margin-bottom:24px">
    <div class="card-header">
        <div class="card-title" style="color:#dc2626">Panggilan Pelayan Aktif</div>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr><th>Meja</th><th>Waktu</th><th class="no-sort">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($waiterCalls as $call)
                <tr>
                    <td><strong>Meja {{ $call->table->number }}</strong></td>
                    <td>{{ $call->created_at->diffForHumans() }}</td>
                    <td>
                        <form action="{{ route('admin.waiter-calls.done', $call) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ── Peringkat Kategori & Menu Terlaris ──────────────────────────── --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
    <div class="card" style="margin-bottom:0">
        <div class="card-header"><div class="card-title">Peringkat Kategori</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th style="width:36px">#</th><th>Kategori</th><th style="text-align:right">Terjual</th></tr>
                </thead>
                <tbody>
                    @forelse($topCategories as $i => $cat)
                    <tr>
                        <td>
                            @if($i === 0) <span style="font-weight:700;color:#d97706">1</span>
                            @elseif($i === 1) <span style="font-weight:700;color:#6b7280">2</span>
                            @elseif($i === 2) <span style="font-weight:700;color:#92400e">3</span>
                            @else <span style="color:#9ca3af">{{ $i + 1 }}</span>
                            @endif
                        </td>
                        <td style="font-weight:500">{{ $cat->name }}</td>
                        <td style="text-align:right;font-weight:700;color:#0e6446">
                            {{ number_format($cat->total_qty, 0, ',', '.') }}
                            <span style="font-size:11px;font-weight:400;color:#9ca3af">item</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:#9ca3af;padding:24px">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-bottom:0">
        <div class="card-header"><div class="card-title">Menu Terlaris</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th style="width:36px">#</th><th>Menu</th><th style="text-align:right">Terjual</th></tr>
                </thead>
                <tbody>
                    @forelse($topMenus as $i => $item)
                    <tr>
                        <td>
                            @if($i === 0) <span style="font-weight:700;color:#d97706">1</span>
                            @elseif($i === 1) <span style="font-weight:700;color:#6b7280">2</span>
                            @elseif($i === 2) <span style="font-weight:700;color:#92400e">3</span>
                            @else <span style="color:#9ca3af">{{ $i + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:500;font-size:13px">{{ $item->menu->name }}</div>
                            <div style="font-size:11px;color:#9ca3af">{{ $item->menu->category->name }}</div>
                        </td>
                        <td style="text-align:right;font-weight:700;color:#0e6446">
                            {{ number_format($item->total_qty, 0, ',', '.') }}
                            <span style="font-size:11px;font-weight:400;color:#9ca3af">item</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:#9ca3af;padding:24px">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── Info ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Selamat Datang</div>
        <a href="{{ route('admin.orders.monitor') }}" class="btn btn-primary btn-sm">Monitor Pesanan</a>
    </div>
    <div class="card-body">
        <p style="color:#6b7280;font-size:13px">
            Halaman ini menampilkan ringkasan aktivitas Pivot Caffe secara real-time.
            Halaman diperbarui otomatis setiap 10 detik.
        </p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    setTimeout(function() { location.reload(); }, 10000);
    function toggleCustomDate() {
        const el = document.getElementById('custom-date-form');
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endpush
