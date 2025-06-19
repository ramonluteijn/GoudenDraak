@extends('layouts.layout')

@section('title', 'Review')
@section('main')
    <div class="container">
        <form action="{{route('survey.store')}}" method="post">
            @csrf
            @foreach($questions as $question)
                <label for="{{$question->id}}">{{$question->question}}</label>
                <input id="{{$question->id}}" type="text" name="answers[{{$question->id}}]" class="form-control mb-3">
                @if($errors->has('answers.'.$question->id))
                    <span class="text-danger">{{ $errors->first('answer.'.$question->id) }}</span>
                @endif
            @endforeach
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@stop
