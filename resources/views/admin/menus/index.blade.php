@extends('layouts.admin')
@section('title', 'Kelola Menu')
@section('page-title', 'Kelola Menu')

@section('content')

{{-- ── Card Terlaris ────────────────────────────────────────────────── --}}
<div class="stats-grid" style="margin-bottom:24px">

    @php
    $cards = [
        ['label' => 'Menu Terlaris',    'data' => $topMenuOverall, 'sub' => $topMenuOverall?->menu?->category?->name ?? ''],
        ['label' => 'Kopi Terlaris',    'data' => $topKopi,        'sub' => 'Kategori Kopi'],
        ['label' => 'Makanan Terlaris', 'data' => $topMakanan,     'sub' => 'Kategori Makanan'],
        ['label' => 'Minuman Terlaris', 'data' => $topMinuman,     'sub' => 'Non-Kopi / Minuman Dingin'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="stat-card">
        <div class="stat-label">{{ $card['label'] }}</div>
        @if($card['data'])
            <div class="stat-value" style="font-size:22px;line-height:1.2;margin-top:6px">
                {{ $card['data']->menu->name }}
            </div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px">{{ $card['sub'] }}</div>
            <div style="margin-top:6px;font-size:13px;font-weight:600;color:#0e6446">
                {{ number_format($card['data']->total_qty, 0, ',', '.') }}
                <span style="font-weight:400;color:#9ca3af">terjual</span>
            </div>
        @else
            <div style="font-size:13px;color:#9ca3af;margin-top:10px">Belum ada data</div>
        @endif
    </div>
    @endforeach

</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Menu</div>
        <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modal-create-menu')">
            + Tambah Menu
        </button>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:60px">Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td>
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}"
                             style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #d7d7d7">
                    </td>
                    <td>
                        <div style="font-weight:500">{{ $menu->name }}</div>
                        <div style="font-size:12px;color:#6b7280">{{ Str::limit($menu->description, 55) }}</div>
                    </td>
                    <td>{{ $menu->category->name }}</td>
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        @if($menu->is_available)
                            <span class="badge badge-success">Tersedia</span>
                        @else
                            <span class="badge badge-danger">Tidak Tersedia</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            <form action="{{ route('admin.menus.toggle', $menu) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $menu->is_available ? 'btn-warning' : 'btn-success' }}">
                                    {{ $menu->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <button type="button" class="btn btn-secondary btn-sm"
                                onclick="openEditMenu(
                                    {{ $menu->id }},
                                    '{{ addslashes($menu->name) }}',
                                    {{ $menu->category_id }},
                                    '{{ addslashes($menu->description ?? '') }}',
                                    '{{ $menu->price }}',
                                    {{ $menu->is_available ? 'true' : 'false' }},
                                    '{{ $menu->image_url }}'
                                )">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDelete(
                                    '{{ route('admin.menus.destroy', $menu) }}',
                                    '{{ addslashes($menu->name) }}',
                                    'Apakah Anda yakin ingin menghapus menu <strong>{{ addslashes($menu->name) }}</strong>?<br><span style=\'color:#dc2626;font-size:12px\'>Gambar menu juga akan dihapus.</span>'
                                )">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#6b7280;padding:32px">Belum ada menu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $menus->links() }}</div>
</div>

{{-- ── Modal Create ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-menu">
    <div class="modal modal-lg">
        <div class="modal-header">
            <div class="modal-title">Tambah Menu</div>
            <button class="modal-close" onclick="closeModal('modal-create-menu')">×</button>
        </div>
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Menu <span style="color:#dc2626">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama menu" required>
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group">
                        <label>Kategori <span style="color:#dc2626">*</span></label>
                        <select name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp) <span style="color:#dc2626">*</span></label>
                        <input type="number" name="price" value="{{ old('price') }}" min="0" step="500" placeholder="25000" required>
                        @error('price') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="2" placeholder="Deskripsi menu...">{{ old('description') }}</textarea>
                    @error('description') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Gambar (jpg, jpeg, png — maks 2MB)</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png" onchange="previewImage(this, 'preview-create')">
                    @error('image') <div class="field-error">{{ $message }}</div> @enderror
                    <img id="preview-create" src="" alt="" style="display:none;margin-top:8px;width:80px;height:80px;object-fit:cover;border-radius:6px;border:1px solid #d7d7d7">
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:10px">
                    <input type="checkbox" name="is_available" value="1"
                        {{ old('is_available', '1') ? 'checked' : '' }} style="width:auto" id="create-available">
                    <label for="create-available" style="margin:0">Tersedia</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-menu')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal Edit ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-menu">
    <div class="modal modal-lg">
        <div class="modal-header">
            <div class="modal-title">Edit Menu</div>
            <button class="modal-close" onclick="closeModal('modal-edit-menu')">×</button>
        </div>
        <form id="edit-menu-form" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Menu <span style="color:#dc2626">*</span></label>
                    <input type="text" name="name" id="edit-menu-name" placeholder="Nama menu" required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group">
                        <label>Kategori <span style="color:#dc2626">*</span></label>
                        <select name="category_id" id="edit-menu-category" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp) <span style="color:#dc2626">*</span></label>
                        <input type="number" name="price" id="edit-menu-price" min="0" step="500" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" id="edit-menu-desc" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label>Ganti Gambar (opsional)</label>
                    <div id="edit-current-img-wrap" style="margin-bottom:8px">
                        <img id="edit-current-img" src="" alt=""
                             style="width:64px;height:64px;object-fit:cover;border-radius:6px;border:1px solid #d7d7d7">
                        <div style="font-size:11px;color:#6b7280;margin-top:3px">Gambar saat ini</div>
                    </div>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png" onchange="previewImage(this, 'preview-edit')">
                    <img id="preview-edit" src="" alt="" style="display:none;margin-top:8px;width:64px;height:64px;object-fit:cover;border-radius:6px;border:1px solid #d7d7d7">
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:10px">
                    <input type="checkbox" name="is_available" value="1" style="width:auto" id="edit-menu-available">
                    <label for="edit-menu-available" style="margin:0">Tersedia</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-menu')">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui Menu</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openEditMenu(id, name, categoryId, desc, price, isAvailable, imgUrl) {
    const f = document.getElementById('edit-menu-form');
    f.action = '/admin/menus/' + id;
    document.getElementById('edit-menu-name').value = name;
    document.getElementById('edit-menu-category').value = categoryId;
    document.getElementById('edit-menu-price').value = price;
    document.getElementById('edit-menu-desc').value = desc;
    document.getElementById('edit-menu-available').checked = isAvailable;

    const imgEl = document.getElementById('edit-current-img');
    const imgWrap = document.getElementById('edit-current-img-wrap');
    if (imgUrl) {
        imgEl.src = imgUrl;
        imgWrap.style.display = 'block';
    } else {
        imgWrap.style.display = 'none';
    }

    // Reset file input & preview
    f.querySelector('input[type="file"]').value = '';
    const prev = document.getElementById('preview-edit');
    prev.src = ''; prev.style.display = 'none';

    openModal('modal-edit-menu');
}

@if($errors->any())
    @if(old('_method') === 'PUT')
        openModal('modal-edit-menu');
    @else
        openModal('modal-create-menu');
    @endif
@endif
</script>
@endpush
