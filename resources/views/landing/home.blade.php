@extends('layouts.landing')

@section('title', 'Home - Pivot Caffe')

@push('styles')
<style>
    .hero-section {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: var(--bg);
        padding: 60px 20px;
        min-height: 75vh;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 20px;
        line-height: 1.2;
        letter-spacing: -1px;
    }

    .hero-title span {
        color: var(--primary);
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-light);
        margin-bottom: 40px;
        font-weight: 300;
    }

    .hero-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 15px;
    }

    .btn-text {
        border: none;
        text-decoration: underline;
        background: transparent;
        color: var(--primary);
    }

    .btn-text:hover {
        color: var(--primary-light);
    }

    .table-selection-form {
        display: flex;
        gap: 10px;
        background: white;
        padding: 8px;
        border-radius: 8px;
        border: var(--border);
        max-width: 500px;
        margin: 0 auto 20px auto;
        align-items: center;
    }

    .table-selection-form select {
        flex: 1;
        border: none;
        background: transparent;
        padding: 12px 20px;
        font-family: inherit;
        font-size: 1rem;
        color: var(--text);
        cursor: pointer;
        outline: none;
    }

    .table-selection-form select:focus {
        outline: none;
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
        .hero-subtitle { font-size: 1.1rem; }
        .hero-actions { flex-direction: column; }
        .table-selection-form {
            flex-direction: column;
            border-radius: 16px;
            padding: 15px;
        }
        .table-selection-form select {
            width: 100%;
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
        }
        .table-selection-form .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="hero-content fade-in-up">
        <h1 class="hero-title">{!! str_replace('Pivot Caffe', '<span>Pivot Caffe</span>', htmlspecialchars($heroTitle)) !!}</h1>
        <p class="hero-subtitle">{{ $heroSubtitle }}</p>
        
        <div class="table-selection-form">
            <select id="table-select">
                <option value="">Pilih Meja Anda...</option>
                @foreach($tables as $table)
                    <option value="{{ $table->qr_token }}">Meja {{ $table->number }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary" onclick="goToMenu()">Lihat Menu</button>
        </div>
        
        <div class="hero-actions">
            <a href="{{ route('landing.about') }}" class="btn btn-text">Pelajari Lebih Lanjut tentang Kami</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function goToMenu() {
        const token = document.getElementById('table-select').value;
        if (!token) {
            alert('Silakan pilih meja Anda terlebih dahulu untuk melihat menu.');
            return;
        }
        window.location.href = '/order/' + token;
    }
</script>
@endpush

