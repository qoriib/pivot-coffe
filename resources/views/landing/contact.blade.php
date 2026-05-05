@extends('layouts.landing')

@section('title', 'Hubungi Kami - Pivot Caffe')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(rgba(212, 163, 115, 0.9), rgba(212, 163, 115, 0.9)), url('{{ asset('images/display-3.png') }}');
        background-size: cover;
        background-position: center;
        color: var(--primary-dark);
        padding: 160px 0 100px;
        text-align: center;
    }

    .page-title {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .contact-section {
        padding: 100px 0;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 60px;
    }

    .contact-info-card {
        background: var(--primary-dark);
        color: white;
        padding: 50px;
        border-radius: 20px;
        height: 100%;
    }

    .contact-info-card h3 {
        font-size: 2rem;
        margin-bottom: 30px;
        color: var(--accent);
    }

    .info-item {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-icon {
        min-width: 50px;
        height: 50px;
        border-radius: 12px;
        background: rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: 1.2rem;
    }

    .info-text h4 {
        margin-bottom: 5px;
        font-family: 'Outfit', sans-serif;
    }

    .info-text p {
        color: rgba(255,255,255,0.6);
    }

    .contact-form-container h2 {
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 40px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        color: var(--text);
    }

    .form-control {
        width: 100%;
        padding: 15px 20px;
        border-radius: 12px;
        border: 1px solid #ddd;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(27, 67, 50, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    @media (max-width: 992px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
        .page-title { font-size: 3rem; }
    }

    @media (max-width: 768px) {
        .page-header { padding: 120px 0 60px; }
        .page-title { font-size: 2.5rem; }
        .contact-section { padding: 60px 0; }
        .contact-info-card { padding: 30px; }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title font-serif fade-in-up">Hubungi Kami</h1>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info-card fade-in-up">
                <h3 class="font-serif">Mari Berbincang</h3>
                <p style="margin-bottom: 40px; color: rgba(255,255,255,0.6);">Punya pertanyaan atau ingin bekerja sama? Jangan ragu untuk menghubungi kami melalui saluran di bawah ini.</p>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-text">
                        <h4>Lokasi</h4>
                        <p>{{ $address ?: '4F2W+X6 Padang MAS, Kabupaten Karo, Sumatera Utara' }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="info-text">
                        <h4>Telepon</h4>
                        <p>{{ $phone ?: '+62 812-3456-7890' }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-text">
                        <h4>Email</h4>
                        <p>{{ $email ?: 'hello@pivotcoffee.id' }}</p>
                    </div>
                </div>

                <div class="footer-social" style="margin-top: 40px;">
                    <a href="https://www.instagram.com/pivotco.op/" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="contact-form-container fade-in-up" style="animation-delay: 0.2s;">
                <h2 class="font-serif">Kirim Pesan</h2>
                
                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('landing.contact.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan Anda</label>
                        <textarea name="message" id="message" class="form-control" placeholder="Apa yang ingin Anda sampaikan?" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Kirim Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Maps Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-title fade-in-up">
            <h2 class="font-serif">Temukan Lokasi Kami</h2>
            <p>Kami berlokasi di jantung Kabupaten Karo, tempat yang sempurna untuk menikmati udara segar dan kopi hangat.</p>
        </div>
        
        <div class="maps-container fade-in-up" style="height: 450px; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow);">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.354117861!2d98.48!3d3.11!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x303102375836a793%3A0x6b1f2e8f1f1f1f1f!2s4F2W%2BX6%20Padang%20MAS%2C%20Kabupaten%20Karo%2C%20Sumatera%20Utara!5e0!3m2!1sen!2sid!4v1715000000000!5m2!1sen!2sid" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</section>
@endsection
