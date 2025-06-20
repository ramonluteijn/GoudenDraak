@extends('layouts.layout')

@section('title', 'Order Details')

@section('main')
    <div class="container">
        <div class="content-block">
            <div class="row">
                <h1>Order #{{ $order->id }}</h1>
                <div class="order-info">
                    <p><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                    <p><strong>Total:</strong> €{{ number_format($order->price, 2) }}</p>
                </div>
            </div>
            <h2>Details</h2>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Aantal</th>
                    <th scope="col">Prijs per stuk</th>
                    <th scope="col">Subtotaal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name ?? 'Product' }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>€{{ number_format($detail->product->price, 2) }}</td>
                        <td>€{{ number_format($detail->quantity * $detail->product->price, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Terug naar orders</a>
        </div>
    </div>
@endsection
