@extends('layouts.landing')

@section('title', 'About - Pivot Caffe')

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

    .about-content {
        max-width: 800px;
        margin: 60px auto;
        padding: 40px;
        background: white;
        border-radius: 8px;
        border: var(--border);
        text-align: center;
    }

    .about-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-light);
        margin-bottom: 30px;
    }

    .about-images {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .about-img {
        border-radius: 8px;
        border: var(--border);
        object-fit: cover;
        max-width: 100%;
        height: auto;
    }

    .delay-1 {
        animation-delay: 0.2s;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title fade-in-up">{{ $aboutTitle }}</h1>
    </div>
</div>

<div class="container">
    <div class="about-content fade-in-up delay-1">
        <div class="about-text">
            {!! nl2br(htmlspecialchars($aboutText)) !!}
        </div>
        
        <div class="about-images">
            <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=300&h=200&q=80" alt="Coffee" class="about-img">
            <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=300&h=200&q=80" alt="Cafe Interior" class="about-img">
        </div>
    </div>
</div>
@endsection
