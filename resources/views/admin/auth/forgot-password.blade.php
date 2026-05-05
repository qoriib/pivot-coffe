<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Lupa Password — Pivot Caffe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .box { background: #fff; border: 1px solid #d7d7d7; border-radius: 10px; padding: 40px; width: 100%; max-width: 400px; }
        h1 { font-size: 20px; font-weight: 700; color: #0e6446; margin-bottom: 8px; }
        p { font-size: 13px; color: #6b7280; margin-bottom: 24px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 5px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #d7d7d7; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; }
        input:focus { outline: none; border-color: #0e6446; }
        .btn { width: 100%; padding: 11px; background: #0e6446; color: white; border: none; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 12px; }
        .back { display: block; text-align: center; margin-top: 14px; font-size: 13px; color: #0e6446; text-decoration: none; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 16px; }
        .field-error { color: #dc2626; font-size: 12px; margin-top: 4px; }
    </style>
</head>
<body>
<div class="box">
    <div style="text-align:center;margin-bottom:20px">
        <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe"
             style="height:48px;width:auto;object-fit:contain">
    </div>
    <h1>Reset Password</h1>
    <p>Masukkan email Anda dan kami akan mengirimkan link reset password.</p>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.password.email') }}" method="POST">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email') <div class="field-error">{{ $message }}</div> @enderror
        <button type="submit" class="btn">Kirim Link Reset</button>
    </form>
    <a href="{{ route('admin.login') }}" class="back">Kembali ke login</a>
</div>
</body>
</html>
