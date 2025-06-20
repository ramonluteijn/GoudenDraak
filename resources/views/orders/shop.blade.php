@extends('layouts.default')

@section('content')

    @foreach($categories as $category)
        <div class="category-section">
            <div class="category-title">{{ $category['name'] }}</div>
            <table class="table">
                <thead>
                <tr>
                    <th>Nummer</th>
                    <th>Naam</th>
                    <th>Beschrijving</th>
                    <th>Prijs</th>
                </tr>
                </thead>
                <tbody>
                @foreach($category['products'] as $product)
                    <tr class="product-row" onclick="window.location='{{ route('shop.addtocart', ['id' => $product['id']]) }}'">
                        <td>{{ $product['id'] }}</td>
                        <td>
                            <a class="product-link" href="{{ route('shop.addtocart', ['id' => $product['id']]) }}">
                                {{ $product['name'] }}
                            </a>
                        </td>
                        <td>{{ $product['description'] }}</td>
{{--                        <td>&euro; {{ number_format($product['price'], 2) }}</td>--}}
                        <td>
                            @if($product->discounted_price)
                                <span style="text-decoration: line-through;">&euro; {{ number_format($product->original_price, 2) }}</span>
                                <strong style="color: #d9534f;">&euro; {{ number_format($product->discounted_price, 2) }}</strong>
                                @else
                                    &euro; {{ number_format($product->original_price, 2) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <p><a href="{{ route('session.destroy') }}">Klik hier om je bestelling af te ronden</a></p>

@endsection

@if(session('order_id'))
    <div class="cart-summary" style="margin-bottom:2rem; padding:1rem; background:#f8f8f8; border-radius:8px;">
        <strong>Cart:</strong>
        <ul>
            @foreach($order->products as $product)
                <li>
                    {{ $product->name }} - &euro;{{ number_format($product->pivot->price, 2) }}
                    <a href="{{ route('shop.removefromcart', ['id' => $product->id]) }}" class="btn btn-danger btn-sm">-</a>
                    <span class="badge badge-secondary">{{ $product->pivot->quantity }}</span>
                    <a href="{{ route('shop.addtocart', ['id' => $product->id]) }}" class="btn btn-success btn-sm">+</a>
                </li>
            @endforeach
        </ul>
        <p><strong>Total:</strong> &euro;{{ number_format($order->price, 2) }}</p>
    </div>
@endif

{{--session()->forget('order_id');--}}
