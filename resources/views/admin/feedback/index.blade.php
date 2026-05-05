@extends('layouts.admin')
@section('title', 'Feedback')
@section('page-title', 'Feedback Pelanggan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Semua Feedback</div>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr><th>Rating</th><th>Komentar</th><th>Pesanan</th><th>Meja</th><th>Tanggal</th><th class="no-sort">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $fb)
                <tr>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color:{{ $i <= $fb->rating ? '#d97706' : '#d7d7d7' }}">&#9733;</span>
                        @endfor
                        <span style="font-size:12px;color:#6b7280;margin-left:4px">({{ $fb->rating }}/5)</span>
                    </td>
                    <td style="max-width:200px">{{ $fb->comment ?? '—' }}</td>
                    <td style="font-size:12px;font-family:monospace">
                        <a href="{{ route('admin.orders.show', $fb->order) }}" style="color:#0e6446">
                            {{ $fb->order->transaction_id }}
                        </a>
                    </td>
                    <td>Meja {{ $fb->order->table->number }}</td>
                    <td style="font-size:12px">{{ $fb->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete(
                                '{{ route('admin.feedback.destroy', $fb) }}',
                                'feedback ini',
                                'Apakah Anda yakin ingin menghapus feedback dari pesanan <strong>{{ $fb->order->transaction_id }}</strong>?'
                            )">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#6b7280;padding:32px">Belum ada feedback.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $feedbacks->links() }}</div>
</div>
@endsection
