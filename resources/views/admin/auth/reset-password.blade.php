<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Reset Password — Pivot Caffe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .box { background: #fff; border: 1px solid #d7d7d7; border-radius: 10px; padding: 40px; width: 100%; max-width: 400px; }
        h1 { font-size: 20px; font-weight: 700; color: #0e6446; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 5px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #d7d7d7; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; }
        input:focus { outline: none; border-color: #0e6446; }
        .btn { width: 100%; padding: 11px; background: #0e6446; color: white; border: none; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; }
        .field-error { color: #dc2626; font-size: 12px; margin-top: 4px; }
    </style>
</head>
<body>
<div class="box">
    <h1>Password Baru</h1>
    <form action="{{ route('admin.password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $email ?? old('email') }}" required>
            @error('email') <div class="field-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" required>
            @error('password') <div class="field-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn">Reset Password</button>
    </form>
</div>
</body>
</html>
