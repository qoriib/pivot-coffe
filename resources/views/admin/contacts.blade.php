@extends('layouts.admin')

@section('title', 'Pesan Kontak')
@section('page-title', 'Pesan Kontak')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Pesan Masuk</div>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th style="width: 150px;">Tanggal</th>
                    <th style="width: 100px;" class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr>
                        <td>{{ ($messages->currentPage() - 1) * $messages->perPage() + $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 500;">{{ $msg->name }}</div>
                            @if(!$msg->is_read)
                                <span class="badge badge-danger">Baru</span>
                            @endif
                        </td>
                        <td style="color: var(--text-muted); font-size: 12px;">{{ $msg->email }}</td>
                        <td>
                            <div style="max-width: 400px; white-space: pre-wrap; font-size: 12px; color: var(--text-muted);">{{ $msg->message }}</div>
                        </td>
                        <td style="font-size: 12px; color: var(--text-muted);">{{ $msg->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" 
                                onclick="confirmDelete('{{ route('admin.contacts.destroy', $msg->id) }}', 'Pesan dari {{ $msg->name }}')">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            Belum ada pesan kontak yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->hasPages())
        <div class="pagination">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
