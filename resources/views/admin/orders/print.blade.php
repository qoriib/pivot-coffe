<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Nota — {{ $order->transaction_id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; font-size: 13px; color: #1a1a1a; padding: 20px; max-width: 320px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 1px dashed #ccc; padding-bottom: 12px; }
        .header h1 { font-size: 18px; font-weight: 700; color: #0e6446; }
        .header p { font-size: 11px; color: #6b7280; }
        .info { margin-bottom: 12px; font-size: 12px; }
        .info div { display: flex; justify-content: space-between; padding: 2px 0; }
        .items { border-top: 1px dashed #ccc; border-bottom: 1px dashed #ccc; padding: 10px 0; margin-bottom: 10px; }
        .item { display: flex; justify-content: space-between; padding: 3px 0; font-size: 12px; }
        .totals div { display: flex; justify-content: space-between; padding: 2px 0; font-size: 12px; }
        .total-final { font-weight: 700; font-size: 14px; border-top: 1px solid #ccc; padding-top: 6px; margin-top: 4px; }
        .footer { text-align: center; margin-top: 16px; font-size: 11px; color: #6b7280; border-top: 1px dashed #ccc; padding-top: 12px; }
        .print-btn { display: block; text-align: center; margin: 20px auto; padding: 10px 24px; background: #0e6446; color: white; border: none; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; cursor: pointer; }
        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pivot Caffe</h1>
        <p>Nota Pembelian</p>
    </div>

    <div class="info">
        <div><span>No. Transaksi</span><span style="font-size:10px">{{ $order->transaction_id }}</span></div>
        <div><span>Meja</span><span>Meja {{ $order->table->number }}</span></div>
        <div><span>Pelanggan</span><span>{{ $order->customer_name }}</span></div>
        <div><span>Tanggal</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
        <div><span>Pembayaran</span><span>{{ $order->payment_method === 'cash' ? 'Tunai' : 'E-Wallet' }}</span></div>
    </div>

    <div class="items">
        @foreach($order->items as $item)
        <div class="item" style="flex-wrap: wrap;">
            <span>
                {{ $item->quantity }}x {{ $item->menu->name }}
                @if($item->notes)
                <div style="font-size:10px;color:#6b7280;padding-left:14px;font-style:italic">
                    &bull; {{ $item->notes }}
                </div>
                @endif
            </span>
            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
        @endforeach
    </div>

    <div class="totals">
        <div><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
        @if($order->discount > 0)
        <div><span>Diskon</span><span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span></div>
        @endif
        <div class="total-final"><span>TOTAL</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
    </div>

    <div class="footer">
        <p>Terima kasih telah berkunjung!</p>
        <p>Pivot Caffe</p>
    </div>

    <button class="print-btn" onclick="window.print()">Cetak Nota</button>
</body>
</html>
