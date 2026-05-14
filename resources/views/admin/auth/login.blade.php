<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Login Admin — Pivot Caffe</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #1b4332;
            --primary-dark: #081c15;
            --accent: #d4a373;
            --accent-light: #faedcd;
            --text: #1a1a1a;
            --text-light: #6b7280;
            --white: #ffffff;
            --danger: #dc2626;
            --success: #16a34a;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #fef3c7 0%, #fdfcfb 45%, #f0f4f0 100%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-box {
            background: var(--white);
            border-radius: 22px;
            padding: 38px 34px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            width: 100%;
            max-width: 440px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeUp 0.6s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .brand-logo {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .brand-logo img {
            width: 34px;
            height: 34px;
            object-fit: contain;
        }

        .brand-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            color: var(--primary);
        }

        .brand-text p {
            font-size: 13px;
            color: var(--text-light);
            margin-top: 4px;
        }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--primary-dark); }
        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            background: #fafafa;
            transition: all 0.2s ease;
        }
        input:focus { outline: none; border-color: var(--primary); background: #ffffff; box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.15); }
        .field-error { color: var(--danger); font-size: 12px; margin-top: 6px; }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(27, 67, 50, 0.2); }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 14px;
        }
        .alert-success {
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .helper-text {
            margin-top: 14px;
            font-size: 12px;
            color: var(--text-light);
            text-align: center;
        }

        @media (max-width: 600px) {
            body { padding: 30px 16px; }
            .login-box { padding: 30px 24px; }
        }
    </style>
</head>
<body>
<section class="login-box">
        <div class="login-brand">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe">
            </div>
            <div class="brand-text">
                <h1>Masuk Admin</h1>
                <p>Kelola pesanan secara real-time</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->has('email'))
            <div class="alert-error">{{ $errors->first('email') }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        <div class="helper-text">Butuh bantuan? Hubungi manajer outlet.</div>
    </section>
</body>
</html>
