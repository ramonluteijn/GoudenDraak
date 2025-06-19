@extends('layouts.layout')

@section('title', 'Review')
@section('main')
    <div class="container">
        <div class="content-block">
            <h1>Bedankt voor uw deelname!</h1>
            <p>Uw antwoorden zijn succesvol opgeslagen. We waarderen uw tijd en moeite om deze enquête in te vullen.</p>
            <p>Als u nog vragen heeft of meer informatie wilt, aarzel dan niet om contact met ons op te nemen.</p>
            <p>We wensen u een fijne dag toe!</p>
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-primary">Terug naar de startpagina</a>
            </div>
        </div>
    </div>
@stop
