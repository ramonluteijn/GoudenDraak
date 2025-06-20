@extends('layouts.default')

@section('title', __('Login'))

@section('content')
    <form method="POST" action="{{ route('login.save') }}" class="">
        @csrf
        <div class="mb-6">
            <x-forms.input-field type="email" name="email" label="{{__('email')}}" :required="true" value="{{old('email')}}"/>
            <x-forms.input-field type="password" name="password" label="{{__('password')}}" :required="true"/>
        </div>
        <div class="flex items-center justify-between">
            <a href="{{route('register.show')}}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">{{__('Register here')}}</a>
            <input type="submit" value="{{__('Login')}}" class="">
        </div>
    </form>
@stop
