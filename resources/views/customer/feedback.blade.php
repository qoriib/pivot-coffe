@extends('layouts.customer')

@section('title', 'Beri Rating — Pivot Caffe')

@push('styles')
<style>
    .star-rating { display: flex; gap: 8px; margin-bottom: 4px; }
    .star-btn {
        font-size: 36px;
        cursor: pointer;
        background: none;
        border: none;
        color: #d7d7d7;
        padding: 0;
        transition: color 0.1s;
    }
    .star-btn.active { color: #d97706; }
</style>
@endpush

@section('content')
<div style="text-align:center;padding:20px 0 16px">
    <div style="font-size:18px;font-weight:700;margin-bottom:4px">Beri Rating</div>
    <div style="font-size:13px;color:#6b7280">Pesanan {{ $order->transaction_id }}</div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('customer.feedback.store', $order->transaction_id) }}" method="POST">
            @csrf
            <div class="form-group" style="text-align:center">
                <label style="font-size:14px;font-weight:500;margin-bottom:12px;display:block">
                    Bagaimana pengalaman Anda?
                </label>
                <div class="star-rating" style="justify-content:center">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" class="star-btn" data-value="{{ $i }}" onclick="setRating({{ $i }})">&#9733;</button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 0) }}">
                @error('rating') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="comment">Komentar (opsional)</label>
                <textarea id="comment" name="comment" rows="3"
                    placeholder="Ceritakan pengalaman Anda...">{{ old('comment') }}</textarea>
                @error('comment') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Kirim Rating</button>
        </form>
    </div>
</div>

<div style="text-align:center;margin-top:12px">
    <a href="{{ route('customer.status', $order->transaction_id) }}" style="color:#6b7280;font-size:13px">
        Lewati
    </a>
</div>
@endsection

@push('scripts')
<script>
function setRating(value) {
    document.getElementById('rating-input').value = value;
    document.querySelectorAll('.star-btn').forEach((btn, i) => {
        btn.classList.toggle('active', i < value);
    });
}
// Restore old value
const oldVal = parseInt(document.getElementById('rating-input').value);
if (oldVal > 0) setRating(oldVal);
</script>
@endpush
