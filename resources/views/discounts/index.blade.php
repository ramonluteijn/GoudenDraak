@extends('layouts.default')
@section('title', 'Aanbiedingen')

@section('content')
    <div class="container">
        <div class="content-block">
            @if($discounts->isEmpty())
                <p>Er zijn momenteel geen aanbiedingen beschikbaar.</p>
            @else
                <table class="discount-table">
                    <thead>
                    <tr>
                        <th>Productnaam</th>
                        <th>Originele prijs</th>
                        <th>Korting</th>
                        <th>Prijs na korting</th>
                        <th>Geldig tot</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discounts as $discount)
                        <tr>
                            <td>{{ $discount->product->name }}</td>
                            <td>€{{ number_format($discount->product->price, 2) }}</td>
                            <td>{{ $discount->discount }}% korting</td>
                            <td>€{{ number_format($discount->product->price * (1 - $discount->discount / 100), 2) }}</td>
                            <td>{{ $discount->end_date->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
