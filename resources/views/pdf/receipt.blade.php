<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { size: 85mm 100mm; margin: 8px; }
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 0; }
        .header, .footer { text-align: center; }
        .logo { width: 50px; margin-bottom: 4px; }
        .order-info { margin-bottom: 6px; }
        table.products { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        table.products th, table.products td { padding: 2px 3px; border-bottom: 1px solid #eee; text-align: left; }
        table.products th { background: #f7f7f7; font-size: 10px; }
        table.products td.img { width: 22px; }
        .total-row td { font-weight: bold; border-top: 2px solid #333; }
        .footer { margin-top: 10px; font-size: 10px; }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ public_path('images/dragon-small.png') }}" class="logo" alt="Logo">
    <div class="order-info">
        Order #{{ $order->id }}<br>
        {{ $order->created_at->format('d-m-Y H:i') }}
    </div>
</div>
<table class="products">
    <thead>
    <tr>
        <th>Naam</th>
        <th>€ PP</th>
        <th>Aantal</th>
        <th>€ Totaal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->orderDetails as $detail)
        <tr>
            <td>{{ $detail->product->name }}</td>
            <td>{{ number_format($detail->product->price, 2) }}</td>
            <td>{{ $detail->quantity }}</td>
            <td>{{ number_format($detail->product->price * $detail->quantity, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="total-row">
        <td colspan="4" style="text-align:right;">Totaal:</td>
        <td>€{{ number_format($order->price, 2) }}</td>
    </tr>
    </tfoot>
</table>
<div class="footer">
    Bedankt voor uw bezoek!
    <img src="{{ $qrCode }}" alt="QR Code" style="margin-top:6px; width:60px; height:60px; display:block; margin-left:auto; margin-right:auto;">
</div>
</body>
</html>
