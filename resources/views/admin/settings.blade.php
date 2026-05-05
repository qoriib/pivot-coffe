@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 18px; font-weight: 600; color: var(--text-muted);">Konfigurasi Halaman</h2>
        <button type="submit" class="btn btn-primary">
            Simpan Perubahan
        </button>
    </div>

    <div class="settings-grid">
        {{-- Kolom Kiri --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Card Homepage --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Homepage</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="landing_hero_title">Judul Utama (Hero Title)</label>
                        <input type="text" id="landing_hero_title" name="landing_hero_title" value="{{ $settings['landing_hero_title'] ?? '' }}" placeholder="Masukkan judul utama..." required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="landing_hero_subtitle">Sub-Judul (Hero Subtitle)</label>
                        <textarea id="landing_hero_subtitle" name="landing_hero_subtitle" rows="3" placeholder="Masukkan deskripsi singkat di bawah judul..." required>{{ $settings['landing_hero_subtitle'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Card Tentang Kami --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tentang Kami</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="about_title">Judul Halaman About</label>
                        <input type="text" id="about_title" name="about_title" value="{{ $settings['about_title'] ?? '' }}" placeholder="Judul untuk bagian tentang kami..." required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="about_text">Deskripsi / Konten About</label>
                        <textarea id="about_text" name="about_text" rows="8" placeholder="Tuliskan cerita atau informasi kafe Anda..." required>{{ $settings['about_text'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Card Kontak --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Informasi Kontak</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="contact_email">Email Kontak</label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" placeholder="email@contoh.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_phone">Nomor Telepon</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="0812xxxx" required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="contact_address">Alamat Lengkap</label>
                        <textarea id="contact_address" name="contact_address" rows="5" placeholder="Alamat fisik kafe..." required>{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
    .settings-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endsection
