<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Restaurant Menu</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0 20px; }
        h1, h2 { text-align: center; margin-bottom: 0; }
        h2 { margin-top: 30px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px 6px; }
        th { background: #f2f2f2; }
        .price { text-align: right; }
        .discounts { margin-top: 40px; }
        .discounts h3 { margin-bottom: 5px; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <h1>Restaurant Menu</h1>

    @if($discounts->count())
        <div class="discounts">
            <h2>Aanbiedingen</h2>
            <table>
                <thead>
                <tr>
                    <th>Nummer</th>
                    <th>Product</th>
                    <th>Beschrijving</th>
                    <th class="price">Normale Prijs</th>
                    <th class="price">Prijs</th>
                </tr>
                </thead>
                <tbody>
                @foreach($discounts as $discount)
                    <tr>
                        <td>#{{ $discount->product->id }}</td>
                        <td>{!! $discount->product->name !!}</td>
                        <td>{{ $discount->product->description ?? '-' }}</td>
                        <td class="price">
                            &euro; {{ number_format($discount->product->price, 2) }}
                        </td>
                        <td class="price">
                            &euro; {{ number_format($discount->product->price*(1.00-($discount->discount / 100)), 2) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @pageBreak

    @php
        $grouped = $products;
    @endphp

    @foreach($grouped as $category => $items)
        <h2>{{ $category }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Nummer</th>
                    <th>Product</th>
                    <th>Beschrijving</th>
                    <th class="price">Prijs</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $product)
                    <tr>
                        <td>#{{ $product->id }}</td>
                        <td>{!! $product->name !!}</td>
                        <td>{{ $product->description ?? '-' }}</td>
                        <td class="price">&euro; {{ number_format($product->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="footer">
        &copy; {{ date('Y') }} De Gouden Draak. Alle rechten voorbehouden.<br>
    </div>
</body>
</html>
