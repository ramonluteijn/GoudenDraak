<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bevestiging Bestelling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 20px;
        }
        .app-name {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }
        .order-date {
            font-size: 1em;
            margin-bottom: 20px;
        }
        .qr-code {
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="order-date">
    {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}
</div>
<div class="qr-code">
    <img src="{{ $qrCode }}" alt="QR Code" width="120" height="120">
</div>
<p>
    # {{ $order->id }}
</p>
<div class="app-name">
    De Gouden Draak
</div>
</body>
</html>
