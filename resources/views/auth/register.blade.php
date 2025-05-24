@extends('layouts.default')

@section('title', __('Register'))

@section('content')
    <div class="pb-[100px] min-h-[calc(100vh-50px-75px)] flex items-center justify-center">
        <div class="w-full max-w-md">
            <form method="POST" action="{{ route('register.save') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                <x-forms.input-field type="text" name="name" label="{{__('name')}}" type="text" :required="true" value="{{old('name')}}"/>
                <x-forms.input-field type="email" name="email" label="{{__('email')}}" :required="true" value="{{old('email')}}"/>
                <x-forms.input-field type="password" name="password" label="{{__('password')}}" :required="true"/>
                <x-forms.input-field type="password" name="password_confirmation" label="{{__('password confirmation')}}" :required="true"/>
                <div class="flex items-center justify-between">
                    <a href="{{route('login.show')}}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">{{__('Login here')}}</a>
                    <input type="submit" value="{{__('Register')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                </div>
            </form>
        </div>
    </div>
@stop
