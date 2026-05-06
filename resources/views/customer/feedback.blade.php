@extends('layouts.customer')

@section('title', 'Beri Rating — Pivot Caffe')

@push('styles')
<style>
    .feedback-container {
        max-width: 600px;
        margin: 0 auto;
        padding-top: 120px;
        padding-bottom: 80px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .feedback-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: var(--shadow);
        border: var(--border);
        text-align: center;
    }

    .star-rating {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin: 30px 0;
    }

    .star-btn {
        font-size: 45px;
        cursor: pointer;
        background: none;
        border: none;
        color: #e5e7eb;
        padding: 0;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .star-btn:hover {
        transform: scale(1.2);
    }

    .star-btn.active {
        color: var(--accent);
        text-shadow: 0 0 15px rgba(212, 163, 115, 0.3);
    }

    .form-group-p {
        text-align: left;
        margin-bottom: 25px;
    }

    .form-label-p {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: var(--text);
        margin-bottom: 10px;
    }

    .form-textarea-p {
        width: 100%;
        padding: 20px;
        border-radius: 20px;
        border: var(--border);
        background: var(--bg);
        font-family: inherit;
        font-size: 15px;
        transition: all 0.3s;
        resize: none;
    }

    .form-textarea-p:focus {
        outline: none;
        border-color: var(--accent);
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .feedback-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .feedback-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
<div class="feedback-container">
    
    <div class="feedback-header">
        <h1>Beri Penilaian</h1>
        <p style="color: var(--text-light); font-size: 14px;">Pesanan #{{ $order->transaction_id }}</p>
    </div>

    <div class="feedback-card fade-in-up">
        <form action="{{ route('customer.feedback.store', $order->transaction_id) }}" method="POST">
            @csrf
            
            <p style="font-weight: 600; color: var(--primary);">Bagaimana pengalaman kuliner Anda hari ini?</p>
            
            <div class="star-rating">
                @for($i = 1; $i <= 5; $i++)
                <button type="button" class="star-btn" data-value="{{ $i }}" onclick="setRating({{ $i }})">
                    <i class="fas fa-star"></i>
                </button>
                @endfor
            </div>
            
            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 0) }}">
            @error('rating') <div style="color:var(--danger); font-size: 12px; margin-bottom: 20px;">{{ $message }}</div> @enderror

            <div class="form-group-p">
                <label class="form-label-p" for="comment">Saran & Kritik (Opsional)</label>
                <textarea id="comment" name="comment" rows="4" class="form-textarea-p"
                    placeholder="Apa yang bisa kami tingkatkan untuk kunjungan Anda berikutnya?">{{ old('comment') }}</textarea>
                @error('comment') <div style="color:var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 18px;">
                Kirim Penilaian
            </button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('customer.status', $order->transaction_id) }}" style="color: var(--text-light); font-size: 14px; text-decoration: none; border-bottom: 1px solid #ddd; padding-bottom: 2px;">
            Lewati & Kembali ke Status Pesanan
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setRating(value) {
    document.getElementById('rating-input').value = value;
    document.querySelectorAll('.star-btn').forEach((btn, i) => {
        if (i < value) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}

// Restore old value if any
document.addEventListener('DOMContentLoaded', function() {
    const oldVal = parseInt(document.getElementById('rating-input').value);
    if (oldVal > 0) setRating(oldVal);
});
</script>
@endpush
