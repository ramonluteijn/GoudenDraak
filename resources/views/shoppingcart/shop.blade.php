@extends('layouts.default')

@section('title', 'Bestellen')

@section('content')
    <div class="main-content-wrapper">

        <div class="product-section">
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
                                        {!! $product['name'] !!}
                                    </a>
                                </td>
                                <td>{!! $product['description'] !!}</td>
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

            <p><a href="{{ route('shop.shoppingcart.confirmation') }}">Klik hier om je bestelling af te ronden</a></p>
        </div>

        @if(session('order_id'))
            <div class="cart-summary">
                <h2>Winkelwagen</h2>
                <ul class="cart-items">
                    @foreach($order->products as $product)
                        <li class="cart-item">
                            <span class="product-name">{{ $product->name }}</span>
                            <span class="product-price">&euro;{{ number_format($product->pivot->price, 2) }}</span>
                            <div class="quantity-controls">
                                <a href="{{ route('shop.removefromcart', ['id' => $product->id]) }}" class="btn btn-danger btn-sm">-</a>
                                <span>{{ $product->pivot->quantity }}</span>
                                <a href="{{ route('shop.addtocart', ['id' => $product->id]) }}" class="btn btn-success btn-sm">+</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <p class="cart-total"><strong>Totaal:</strong> &euro;{{ number_format($order->price, 2) }}</p>
                <a href="{{ route('shop.shoppingcart.confirmation') }}" class="btn btn-primary btn-block mt-2">Bestelling afronden</a>
            </div>
        @endif

    </div>
@endsection
