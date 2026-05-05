@extends('layouts.landing')

@section('title', 'Pivot Caffe - Premium Coffee Experience')

@push('styles')
<style>
    .hero-section {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/display-main.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white;
        padding: 0 20px;
    }

    .hero-content {
        max-width: 900px;
    }

    .hero-title {
        font-size: 5rem;
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 40px;
        font-weight: 300;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .table-selection-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        padding: 30px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 600px;
        margin: 0 auto;
    }

    .table-selection-card h3 {
        margin-bottom: 20px;
        font-size: 1.2rem;
        font-family: 'Outfit', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .selection-grid {
        display: flex;
        gap: 15px;
    }

    .selection-grid select {
        flex: 1;
        padding: 15px 25px;
        border-radius: 50px;
        border: none;
        background: white;
        font-family: inherit;
        font-size: 1rem;
        outline: none;
        cursor: pointer;
        appearance: none;
    }

    /* Features Section */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
    }

    .feature-card {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow);
        transition: transform 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-icon {
        font-size: 2.5rem;
        color: var(--accent);
        margin-bottom: 25px;
    }

    .feature-card h3 {
        margin-bottom: 15px;
        font-size: 1.5rem;
    }

    /* Gallery Section */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(3, 300px);
        gap: 20px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(27, 67, 50, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        color: white;
        font-size: 1.5rem;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-1 { grid-column: 1 / 3; grid-row: 1 / 3; }
    .gallery-2 { grid-column: 3 / 5; grid-row: 1 / 2; }
    .gallery-3 { grid-column: 3 / 4; grid-row: 2 / 3; }
    .gallery-4 { grid-column: 4 / 5; grid-row: 2 / 3; }
    .gallery-5 { grid-column: 1 / 2; grid-row: 3 / 4; }
    .gallery-6 { grid-column: 2 / 4; grid-row: 3 / 4; }
    .gallery-7 { grid-column: 4 / 5; grid-row: 3 / 4; }

    /* Instagram Section */
    .instagram-feed {
        background: var(--accent-light);
    }

    .insta-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .insta-item {
        aspect-ratio: 1;
        overflow: hidden;
        border-radius: 10px;
    }

    .insta-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Maps Section */
    .maps-container {
        height: 500px;
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    @media (max-width: 992px) {
        .hero-title { font-size: 3.5rem; }
        .features-grid { grid-template-columns: 1fr; }
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: auto;
        }
        .gallery-1, .gallery-2, .gallery-6 { grid-column: span 2; height: 350px; }
        .gallery-3, .gallery-4, .gallery-5, .gallery-7 { grid-column: span 1; height: 250px; }
        .insta-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.8rem; }
        .selection-grid { flex-direction: column; }
        .insta-grid { grid-template-columns: repeat(2, 1fr); }
        .gallery-grid { grid-template-columns: 1fr; }
        .gallery-1, .gallery-2, .gallery-3, .gallery-4, .gallery-5, .gallery-6, .gallery-7 { grid-column: span 1; height: 300px; }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content fade-in-up">
        <h1 class="hero-title font-serif">{{ $heroTitle }}</h1>
        <p class="hero-subtitle">{{ $heroSubtitle }}</p>
        
        <div class="table-selection-card">
            <h3>Pesan Langsung dari Meja Anda</h3>
            <div class="selection-grid">
                <select id="table-select">
                    <option value="">Pilih Nomor Meja...</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->qr_token }}">Meja {{ $table->number }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-accent" onclick="goToMenu()">Buka Menu</button>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in-up">
            <h2>Kualitas dalam Setiap Tetes</h2>
            <p>Kami berkomitmen untuk menyajikan pengalaman kopi yang tak terlupakan melalui proses yang teliti dan penuh cinta.</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card fade-in-up" style="animation-delay: 0.1s;">
                <div class="feature-icon"><i class="fas fa-seedling"></i></div>
                <h3>Biji Pilihan</h3>
                <p>Hanya menggunakan biji kopi arabika dan robusta terbaik yang dipanen langsung dari petani lokal Sumatera.</p>
            </div>
            <div class="feature-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="feature-icon"><i class="fas fa-fire"></i></div>
                <h3>Roasting Sempurna</h3>
                <p>Dipanggang dengan teknik khusus untuk mengeluarkan profil rasa yang unik dan aroma yang memikat.</p>
            </div>
            <div class="feature-card fade-in-up" style="animation-delay: 0.3s;">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>Komunitas</h3>
                <p>Bukan sekadar kafe, Pivot adalah tempat di mana ide-ide bertemu dan komunitas tumbuh bersama.</p>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-title fade-in-up">
            <h2>Galeri Foto</h2>
            <p>Lihat suasana hangat dan detail proses pembuatan kopi kami.</p>
        </div>
        
        <div class="gallery-grid fade-in-up">
            <div class="gallery-item gallery-1">
                <img src="{{ asset('images/display-main.png') }}" alt="Pivot Interior">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item gallery-2">
                <img src="{{ asset('images/display-1.png') }}" alt="Pivot Interior">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item gallery-3">
                <img src="{{ asset('images/display-2.png') }}" alt="Latte Art">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item gallery-4">
                <img src="{{ asset('images/display-3.png') }}" alt="Coffee Beans">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item gallery-5">
                <img src="{{ asset('images/display-4.png') }}" alt="Pivot Space">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item gallery-6">
                <img src="{{ asset('images/display-5.png') }}" alt="Our Vibe">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item gallery-7">
                <img src="{{ asset('images/display-6.png') }}" alt="Fresh Roast">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Section -->
<section class="section-padding instagram-feed">
    <div class="container">
        <div class="section-title fade-in-up">
            <h2 style="color: var(--primary-dark);">@pivotco.op</h2>
            <p>Ikuti perjalanan kami dan dapatkan info promo terbaru di Instagram.</p>
            <a href="https://www.instagram.com/pivotco.op/" target="_blank" class="btn btn-primary" style="margin-top: 20px;">Follow Us</a>
        </div>
        
        <div class="insta-grid fade-in-up">
            <div class="insta-item"><img src="{{ asset('images/display-1.png') }}" alt="Insta Post"></div>
            <div class="insta-item"><img src="{{ asset('images/display-2.png') }}" alt="Insta Post"></div>
            <div class="insta-item"><img src="{{ asset('images/display-3.png') }}" alt="Insta Post"></div>
            <div class="insta-item"><img src="{{ asset('images/display-4.png') }}" alt="Insta Post"></div>
            <div class="insta-item"><img src="{{ asset('images/display-5.png') }}" alt="Insta Post"></div>
            <div class="insta-item"><img src="{{ asset('images/display-6.png') }}" alt="Insta Post"></div>
            <div class="insta-item"><img src="{{ asset('images/display-7.png') }}" alt="Insta Post"></div>
            <div class="insta-item"><img src="{{ asset('images/display-8.png') }}" alt="Insta Post"></div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in-up">
            <h2>Kunjungi Kami</h2>
            <p>4F2W+X6 Padang MAS, Kabupaten Karo, Sumatera Utara. Kami buka setiap hari jam 08:00 - 22:00.</p>
        </div>
        
        <div class="maps-container fade-in-up">
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

@push('scripts')
<script>
    function goToMenu() {
        const token = document.getElementById('table-select').value;
        if (!token) {
            alert('Silakan pilih nomor meja Anda terlebih dahulu.');
            return;
        }
        window.location.href = '/order/' + token;
    }

    // Scroll reveal animation
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });
</script>
@endpush


