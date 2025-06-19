@extends('layouts.layout')

@section('main')
    <x-blocks.hero />
    <div class="container">
        <div class="content-block">
            @yield("content")
        </div>
    </div>
@stop
