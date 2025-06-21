@extends('layouts.layout')

@section('title', 'Bevestiging')

@section('main')
    <div class="container">
        <div class="content-block">
            <h1 class="text-center">Bedankt voor uw bestelling!</h1>
            <p class="text-center">Uw bestelling is succesvol geplaatst. We waarderen uw vertrouwen in ons.</p>
            <p class="text-center">Als u nog vragen heeft of meer informatie nodig heeft, aarzel dan niet om contact met ons op te nemen.</p>
            <p class="text-center">We wensen u een fijne dag toe!</p>
            <a href="{{route('export.receipt.confirmation', ['id' => $orderId])}}" class="">
                <img src="{{$qrcode}}" alt="QR Code" class="img-fluid mx-auto d-block" style="max-width: 200px; margin-top: 20px;">
            </a>
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-primary">Terug naar de startpagina</a>
            </div>
        </div>
    </div>
@stop
