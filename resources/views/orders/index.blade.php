@extends('layouts.default')

@section('title', 'Orders')

@section('content')
    <h1>Orders</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Order nummer</th>
            <th scope="col">Datum</th>
            <th scope="col">Totaal</th>
            <th scope="col">Acties</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at }}</td>
                <td>€{{ number_format($order->price, 2) }}</td>
                <td><a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">Bekijk</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
