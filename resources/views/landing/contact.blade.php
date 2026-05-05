@extends('layouts.landing')

@section('title', 'Contact - Pivot Caffe')

@push('styles')
<style>
    .page-header {
        background: var(--primary);
        color: white;
        padding: 80px 20px;
        text-align: center;
        margin-top: -80px; /* Offset navbar */
        padding-top: 140px; /* Add space for navbar */
        border-bottom: 1px solid var(--primary-dark);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin: 60px 0;
    }

    .contact-info-card {
        background: white;
        padding: 40px;
        border-radius: 8px;
        border: var(--border);
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: var(--bg);
        color: var(--primary);
        border-radius: 8px;
        border: var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .info-details h4 {
        margin: 0 0 5px 0;
        font-size: 1.1rem;
        color: var(--text);
    }

    .info-details p {
        margin: 0;
        color: var(--text-light);
        line-height: 1.5;
    }

    .contact-form {
        background: white;
        padding: 40px;
        border-radius: 8px;
        border: var(--border);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text);
    }

    .form-group input, .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--secondary);
        border-radius: 8px;
        font-family: inherit;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-group input:focus, .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
    }

    .form-submit-btn {
        width: 100%;
    }

    .form-title {
        margin-bottom: 25px;
        font-size: 1.5rem;
    }

    .operational-hours {
        margin-top: auto;
        padding-top: 20px;
    }

    .op-hours-text {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 0.95rem;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title fade-in-up">Hubungi Kami</h1>
    </div>
</div>

<div class="container">
    <div class="contact-grid">
        <div class="contact-info-card fade-in-up delay-1">
            <div class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-details">
                    <h4>Alamat</h4>
                    <p>{{ $address }}</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">📞</div>
                <div class="info-details">
                    <h4>Telepon</h4>
                    <p>{{ $phone }}</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">✉️</div>
                <div class="info-details">
                    <h4>Email</h4>
                    <p>{{ $email }}</p>
                </div>
            </div>

            <div class="operational-hours">
                <p class="op-hours-text">Jam Operasional:<br>Senin - Minggu: 08:00 - 22:00</p>
            </div>
        </div>

        <div class="contact-form fade-in-up delay-2">
            <h3 class="form-title">Kirim Pesan</h3>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('landing.contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="message">Pesan</label>
                    <textarea id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini" required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary form-submit-btn">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
