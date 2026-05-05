<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>QR Code Meja {{ $table->number }} — Pivot Caffe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f5f5f5; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .qr-card { background: white; border: 1px solid #d7d7d7; border-radius: 12px; padding: 32px; text-align: center; max-width: 360px; width: 100%; }
        .brand { font-size: 20px; font-weight: 700; color: #0e6446; margin-bottom: 4px; }
        .table-num { font-size: 28px; font-weight: 700; margin: 12px 0; }
        .qr-wrap { margin: 16px 0; display: flex; justify-content: center; }
        .qr-url { font-size: 11px; color: #6b7280; word-break: break-all; margin-bottom: 16px; }
        .btn-print { padding: 10px 24px; background: #0e6446; color: white; border: none; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; margin-right: 8px; }
        .btn-back { padding: 10px 24px; background: #d7d7d7; color: #1a1a1a; border: none; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
        .actions { margin-top: 16px; }
        @media print {
            body { background: white; }
            .actions { display: none; }
            .qr-card { border: none; box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="qr-card">
        <div class="brand">Pivot Caffe</div>
        <div style="font-size:13px;color:#6b7280">Scan untuk memesan</div>
        <div class="table-num">Meja {{ $table->number }}</div>
        <div class="qr-wrap">
            {!! $qrCode !!}
        </div>
        <div class="qr-url">{{ $url }}</div>
        <div class="actions">
            <button class="btn-print" onclick="window.print()">Cetak QR</button>
            <a href="{{ route('admin.tables.index') }}" class="btn-back">Kembali</a>
        </div>
    </div>
</body>
</html>
