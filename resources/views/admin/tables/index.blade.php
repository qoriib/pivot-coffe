@extends('layouts.admin')
@section('title', 'Kelola Meja')
@section('page-title', 'Kelola Meja')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Meja</div>
        <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modal-create-table')">
            + Tambah Meja
        </button>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th>No. Meja</th>
                    <th>Status</th>
                    <th>Pelanggan</th>
                    <th>QR Token</th>
                    <th>URL Order</th>
                    <th class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tables as $table)
                @php $activeOrder = $table->orders->first(); @endphp
                <tr>
                    <td style="font-weight:600;font-size:15px">Meja {{ $table->number }}</td>
                    <td>
                        @if($activeOrder)
                            @if($activeOrder->order_status === 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($activeOrder->order_status === 'diproses')
                                <span class="badge badge-info">Diproses</span>
                            @endif
                        @else
                            <span class="badge badge-success">Kosong</span>
                        @endif
                    </td>
                    <td style="font-size:13px">
                        @if($activeOrder)
                            <a href="{{ route('admin.orders.show', $activeOrder) }}" style="color:#0e6446;font-weight:500">
                                {{ $activeOrder->customer_name }}
                            </a>
                        @else
                            <span style="color:#9ca3af">—</span>
                        @endif
                    </td>
                    <td style="font-size:11px;font-family:monospace;color:#6b7280">{{ Str::limit($table->qr_token, 20) }}</td>
                    <td style="font-size:12px">
                        <a href="{{ route('customer.home', $table) }}" target="_blank" style="color:#0e6446">
                            {{ Str::limit($table->qr_token, 16) }}...
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.tables.qr', $table) }}" class="btn btn-primary btn-sm">QR Code</a>
                        <button type="button" class="btn btn-secondary btn-sm"
                            onclick="openEditTable({{ $table->id }}, {{ $table->number }})">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete(
                                '{{ route('admin.tables.destroy', $table) }}',
                                'Meja {{ $table->number }}',
                                'Apakah Anda yakin ingin menghapus <strong>Meja {{ $table->number }}</strong>?<br><span style=\'color:#dc2626;font-size:12px\'>Semua data pesanan terkait meja ini juga akan terpengaruh.</span>'
                            )">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#6b7280;padding:32px">Belum ada meja.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $tables->links() }}</div>
</div>

{{-- ── Modal Create ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-table">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">Tambah Meja</div>
            <button class="modal-close" onclick="closeModal('modal-create-table')">×</button>
        </div>
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nomor Meja <span style="color:#dc2626">*</span></label>
                    <input type="number" name="number" value="{{ old('number') }}" min="1" placeholder="Contoh: 11" required>
                    @error('number') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <p style="font-size:12px;color:#6b7280">QR token akan dibuat otomatis.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-table')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal Edit ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-table">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">Edit Meja</div>
            <button class="modal-close" onclick="closeModal('modal-edit-table')">×</button>
        </div>
        <form id="edit-table-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nomor Meja <span style="color:#dc2626">*</span></label>
                    <input type="number" name="number" id="edit-table-number" min="1" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-table')">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditTable(id, number) {
    document.getElementById('edit-table-number').value = number;
    document.getElementById('edit-table-form').action = '/admin/tables/' + id;
    openModal('modal-edit-table');
}

@if($errors->any())
    @if(old('_method') === 'PUT')
        openModal('modal-edit-table');
    @else
        openModal('modal-create-table');
    @endif
@endif
</script>
@endpush
