@extends('layouts.admin')
@section('title', 'Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Kategori</div>
        <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modal-create-category')">
            + Tambah Kategori
        </button>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr><th>Nama</th><th>Slug</th><th>Jumlah Menu</th><th class="no-sort">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td style="font-weight:500">{{ $cat->name }}</td>
                    <td style="font-size:12px;color:#6b7280">{{ $cat->slug }}</td>
                    <td>{{ $cat->menus_count }}</td>
                    <td>
                        <button type="button" class="btn btn-secondary btn-sm"
                            onclick="openEditCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}')">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete(
                                '{{ route('admin.categories.destroy', $cat) }}',
                                '{{ addslashes($cat->name) }}',
                                'Apakah Anda yakin ingin menghapus kategori <strong>{{ addslashes($cat->name) }}</strong>?<br><span style=\'color:#dc2626;font-size:12px\'>Semua menu dalam kategori ini juga akan terpengaruh.</span>'
                            )">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#6b7280;padding:32px">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $categories->links() }}</div>
</div>

{{-- ── Modal Create ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-category">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">Tambah Kategori</div>
            <button class="modal-close" onclick="closeModal('modal-create-category')">×</button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kategori <span style="color:#dc2626">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Kopi, Makanan..." required autofocus>
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-category')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal Edit ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-category">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">Edit Kategori</div>
            <button class="modal-close" onclick="closeModal('modal-edit-category')">×</button>
        </div>
        <form id="edit-category-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kategori <span style="color:#dc2626">*</span></label>
                    <input type="text" name="name" id="edit-category-name"
                        placeholder="Nama kategori" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-category')">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditCategory(id, name) {
    document.getElementById('edit-category-name').value = name;
    document.getElementById('edit-category-form').action = '/admin/categories/' + id;
    openModal('modal-edit-category');
}

// Re-open modal if validation failed
@if($errors->any())
    @if(old('_method') === 'PUT')
        openModal('modal-edit-category');
    @else
        openModal('modal-create-category');
    @endif
@endif
</script>
@endpush
