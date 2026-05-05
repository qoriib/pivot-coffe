<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Login Admin — Pivot Caffe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: #fff;
            border: 1px solid #d7d7d7;
            border-radius: 10px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-brand h1 {
            font-size: 22px;
            font-weight: 700;
            color: #0e6446;
        }
        .login-brand p {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 5px; }
        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d7d7d7;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }
        input:focus { outline: none; border-color: #0e6446; }
        .field-error { color: #dc2626; font-size: 12px; margin-top: 4px; }
        .btn-login {
            width: 100%;
            padding: 11px;
            background: #0e6446;
            color: white;
            border: none;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
        }
        .btn-login:hover { background: #0a4f37; }
        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 14px;
            font-size: 13px;
            color: #0e6446;
            text-decoration: none;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-brand">
        <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe"
             style="height:56px;width:auto;object-fit:contain;margin-bottom:10px;display:block;margin-left:auto;margin-right:auto">
        <p>Masuk ke panel admin</p>
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

    <a href="{{ route('admin.password.request') }}" class="forgot-link">Lupa password?</a>
</div>
</body>
</html>
