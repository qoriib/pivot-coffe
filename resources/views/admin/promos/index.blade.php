@extends('layouts.admin')
@section('title', 'Kelola Promo')
@section('page-title', 'Kelola Promo')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Promo</div>
        <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modal-create-promo')">
            + Tambah Promo
        </button>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr><th>Kode</th><th>Deskripsi</th><th>Tipe</th><th>Nilai</th><th>Berlaku</th><th>Status</th><th class="no-sort">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                <tr>
                    <td style="font-weight:600;font-family:monospace">{{ $promo->code }}</td>
                    <td>{{ $promo->description }}</td>
                    <td>{{ $promo->discount_type === 'percent' ? 'Persen' : 'Nominal' }}</td>
                    <td>
                        @if($promo->discount_type === 'percent')
                            {{ $promo->discount_value }}%
                        @else
                            Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                        @endif
                    </td>
                    <td style="font-size:12px">
                        {{ $promo->valid_from->format('d/m/Y') }} — {{ $promo->valid_until->format('d/m/Y') }}
                    </td>
                    <td>
                        @if($promo->is_active && $promo->isValid())
                            <span class="badge badge-success">Aktif</span>
                        @elseif(!$promo->is_active)
                            <span class="badge badge-secondary">Nonaktif</span>
                        @else
                            <span class="badge badge-danger">Kadaluarsa</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary btn-sm"
                            onclick="openEditPromo(
                                {{ $promo->id }},
                                '{{ addslashes($promo->code) }}',
                                '{{ addslashes($promo->description) }}',
                                '{{ $promo->discount_type }}',
                                '{{ $promo->discount_value }}',
                                {{ $promo->is_active ? 'true' : 'false' }},
                                '{{ $promo->valid_from->format('Y-m-d') }}',
                                '{{ $promo->valid_until->format('Y-m-d') }}'
                            )">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete(
                                '{{ route('admin.promos.destroy', $promo) }}',
                                '{{ addslashes($promo->code) }}',
                                'Apakah Anda yakin ingin menghapus promo <strong>{{ addslashes($promo->code) }}</strong>?'
                            )">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#6b7280;padding:32px">Belum ada promo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $promos->links() }}</div>
</div>

{{-- ── Modal Create ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-promo">
    <div class="modal modal-lg">
        <div class="modal-header">
            <div class="modal-title">Tambah Promo</div>
            <button class="modal-close" onclick="closeModal('modal-create-promo')">×</button>
        </div>
        <form action="{{ route('admin.promos.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                @include('admin.promos._form', ['promo' => null])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-promo')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Promo</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal Edit ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-promo">
    <div class="modal modal-lg">
        <div class="modal-header">
            <div class="modal-title">Edit Promo</div>
            <button class="modal-close" onclick="closeModal('modal-edit-promo')">×</button>
        </div>
        <form id="edit-promo-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                @include('admin.promos._form-edit')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-promo')">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui Promo</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditPromo(id, code, desc, type, value, isActive, validFrom, validUntil) {
    const f = document.getElementById('edit-promo-form');
    f.action = '/admin/promos/' + id;
    f.querySelector('[name="code"]').value = code;
    f.querySelector('[name="description"]').value = desc;
    f.querySelector('[name="discount_type"]').value = type;
    f.querySelector('[name="discount_value"]').value = value;
    f.querySelector('[name="valid_from"]').value = validFrom;
    f.querySelector('[name="valid_until"]').value = validUntil;
    f.querySelector('[name="is_active"]').checked = isActive;
    openModal('modal-edit-promo');
}

@if($errors->any())
    @if(old('_method') === 'PUT')
        openModal('modal-edit-promo');
    @else
        openModal('modal-create-promo');
    @endif
@endif
</script>
@endpush
