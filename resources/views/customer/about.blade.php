@extends('layouts.customer')

@section('title', 'Tentang Kami - Pivot Caffe')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(rgba(27, 67, 50, 0.8), rgba(27, 67, 50, 0.8)), url('{{ asset('images/display-2.png') }}');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 160px 0 100px;
        text-align: center;
    }

    .page-title {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .about-section {
        padding: 100px 0;
    }

    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .about-image {
        position: relative;
    }

    .about-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: var(--shadow);
    }

    .about-image::after {
        content: '';
        position: absolute;
        top: 20px;
        right: -20px;
        width: 100%;
        height: 100%;
        border: 2px solid var(--accent);
        border-radius: 20px;
        z-index: -1;
    }

    .about-text h2 {
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 25px;
    }

    .about-text p {
        font-size: 1.1rem;
        color: var(--text-light);
        margin-bottom: 20px;
        line-height: 1.8;
    }

    @media (max-width: 992px) {
        .about-content {
            grid-template-columns: 1fr;
            gap: 50px;
        }
        .page-title { font-size: 3rem; }
    }

    @media (max-width: 768px) {
        .page-header { padding: 120px 0 60px; }
        .page-title { font-size: 2.5rem; }
        .about-section { padding: 60px 0; }
        .about-text h2 { font-size: 2rem; }
        .about-image::after { display: none; }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title font-serif fade-in-up">{{ $aboutTitle }}</h1>
    </div>
</div>

<section class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-image fade-in-up">
                <img src="{{ asset('images/display-main.png') }}" alt="Pivot Story">
            </div>
            <div class="about-text fade-in-up" style="animation-delay: 0.2s;">
                <h2 class="font-serif">Cerita di Balik Pivot</h2>
                <div class="about-text-body">
                    @if($aboutText)
                        {!! nl2br(htmlspecialchars($aboutText)) !!}
                    @else
                        <p>Pivot Caffe lahir dari keinginan sederhana: menghadirkan secangkir kebahagiaan di tengah hiruk-pikuk keseharian. Nama "Pivot" melambangkan titik balik, tempat di mana Anda bisa berhenti sejenak, berputar dari rutinitas, dan menemukan inspirasi baru.</p>
                        <p>Kami percaya bahwa kopi berkualitas bukan hanya soal rasa, tapi juga soal koneksi. Itulah mengapa setiap biji kopi yang kami seduh dipilih dengan hati-hati dari perkebunan terbaik, dan setiap ruang di kafe kami dirancang untuk membuat Anda merasa seperti di rumah sendiri.</p>
                        <p>Bergabunglah bersama kami dalam perjalanan rasa ini. Temukan sudut ternyaman Anda, nikmati aromanya, dan biarkan setiap sesapan membawa Anda pada ketenangan yang Anda cari.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

