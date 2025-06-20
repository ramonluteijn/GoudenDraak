@extends('layouts.default')

@section('content')
    <h1>Shopping Cart</h1>
    <div class="shopping-cart">
        <p><a href="{{route('shop.create-order')}}">Maak een order aan</a></p>
    </div>
@stop
