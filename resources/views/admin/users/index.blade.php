@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@push('styles')
<style>
.role-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 600;
}
.role-superadmin { background: #fef3c7; color: #92400e; }
.role-admin      { background: #dbeafe; color: #1e40af; }
.role-kasir      { background: #dcfce7; color: #166534; }

.user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: #0e6446; color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; flex-shrink: 0;
}
</style>
@endpush

@section('content')

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:20px">
    @foreach(\App\Models\Admin::$roles as $key => $label)
    @php $count = $users->where('role', $key)->count(); @endphp
    <div class="stat-card" style="padding:16px">
        <div class="stat-label">{{ $label }}</div>
        <div class="stat-value" style="font-size:28px">{{ $count }}</div>
    </div>
    @endforeach
    <div class="stat-card" style="padding:16px">
        <div class="stat-label">Total User</div>
        <div class="stat-value" style="font-size:28px">{{ $users->count() }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar User Terdaftar</div>
        <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modal-create-user')">
            + Tambah User
        </button>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:44px"></th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    </td>
                    <td>
                        <div style="font-weight:500">{{ $user->name }}</div>
                        @if($user->id === auth('admin')->id())
                            <div style="font-size:11px;color:#0e6446;font-weight:600">Anda</div>
                        @endif
                    </td>
                    <td style="color:#6b7280;font-size:13px">{{ $user->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $user->role }}">
                            {{ $user->role_label }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6b7280">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <button type="button" class="btn btn-secondary btn-sm"
                            onclick="openEditUser(
                                {{ $user->id }},
                                '{{ addslashes($user->name) }}',
                                '{{ addslashes($user->email) }}',
                                '{{ $user->role }}'
                            )">
                            Edit
                        </button>
                        @if($user->id !== auth('admin')->id())
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete(
                                '{{ route('admin.users.destroy', $user) }}',
                                '{{ addslashes($user->name) }}',
                                'Apakah Anda yakin ingin menghapus user <strong>{{ addslashes($user->name) }}</strong>?<br><span style=\'color:#dc2626;font-size:12px\'>Akun ini tidak dapat dipulihkan.</span>'
                            )">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        </button>
                        @else
                        <span style="font-size:11px;color:#9ca3af;padding:5px 6px;display:inline-block">Akun aktif</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#6b7280;padding:32px">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Modal Create ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-user">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">Tambah User Baru</div>
            <button class="modal-close" onclick="closeModal('modal-create-user')">×</button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama <span style="color:#dc2626">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required>
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Email <span style="color:#dc2626">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@domain.com" required>
                    @error('email') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Role <span style="color:#dc2626">*</span></label>
                    <select name="role" required>
                        <option value="">Pilih Role</option>
                        @foreach(\App\Models\Admin::$roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Password <span style="color:#dc2626">*</span></label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                    @error('password') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label>Konfirmasi Password <span style="color:#dc2626">*</span></label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-user')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal Edit ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-user">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">Edit User</div>
            <button class="modal-close" onclick="closeModal('modal-edit-user')">×</button>
        </div>
        <form id="edit-user-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama <span style="color:#dc2626">*</span></label>
                    <input type="text" name="name" id="edit-user-name" placeholder="Nama lengkap" required>
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Email <span style="color:#dc2626">*</span></label>
                    <input type="email" name="email" id="edit-user-email" placeholder="email@domain.com" required>
                    @error('email') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Role <span style="color:#dc2626">*</span></label>
                    <select name="role" id="edit-user-role" required>
                        @foreach(\App\Models\Admin::$roles as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div style="border-top:1px solid #f0f0f0;padding-top:14px;margin-top:4px">
                    <div style="font-size:12px;color:#6b7280;margin-bottom:10px">
                        Kosongkan jika tidak ingin mengubah password.
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter">
                        @error('password') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-user')">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditUser(id, name, email, role) {
    document.getElementById('edit-user-name').value  = name;
    document.getElementById('edit-user-email').value = email;
    document.getElementById('edit-user-role').value  = role;
    // Reset password fields
    document.querySelectorAll('#edit-user-form input[type="password"]').forEach(i => i.value = '');
    document.getElementById('edit-user-form').action = '/admin/users/' + id;
    openModal('modal-edit-user');
}

@if($errors->any())
    @if(old('_method') === 'PUT')
        openModal('modal-edit-user');
    @else
        openModal('modal-create-user');
    @endif
@endif
</script>
@endpush
