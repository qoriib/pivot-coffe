@extends('layouts.admin')
@section('title', 'Waiter Calls')
@section('page-title', 'Panggilan Pelayan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Semua Panggilan Pelayan</div>
        <span style="font-size:12px;color:#6b7280">Auto-refresh setiap 10 detik</span>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr><th>Meja</th><th>Status</th><th>Waktu</th><th class="no-sort">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($calls as $call)
                <tr>
                    <td style="font-weight:600">Meja {{ $call->table->number }}</td>
                    <td>
                        @if($call->status === 'pending')
                            <span class="badge badge-warning">Menunggu</span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                    <td style="font-size:12px">
                        {{ $call->created_at->format('d/m/Y H:i') }}
                        <span style="color:#6b7280">({{ $call->created_at->diffForHumans() }})</span>
                    </td>
                    <td>
                        @if($call->status === 'pending')
                        <form action="{{ route('admin.waiter-calls.done', $call) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Tandai Selesai</button>
                        </form>
                        @else
                            <span style="color:#6b7280;font-size:12px">Sudah selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#6b7280;padding:32px">Tidak ada panggilan pelayan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $calls->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
    setTimeout(function() { location.reload(); }, 10000);
</script>
@endpush
