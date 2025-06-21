@extends(backpack_view('blank'))

@section('content')
    @php
        $widgets['before_content'][] = [
             'type'        => 'jumbotron',
             'heading'     => trans('backpack::base.welcome'),
             'content'     => trans('backpack::base.use_sidebar'),
        ];
    @endphp
    <div class="row">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-2">
                <div class="card-body">
                    <h5 class="card-title">Aantal bestellingen vandaag</h5>
                    <p class="card-text" style="font-size:2rem;">{{ $ordersToday ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-info mb-2">
                <div class="card-body">
                    <h5 class="card-title">Omzet vandaag</h5>
                    <p class="card-text" style="font-size:2rem;">€ {{ number_format($revenueToday ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if (!empty($questions))
        @foreach ($questions->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $question)
                    <div class="col-md-4 mb-2">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Antwoorden voor vraag #{{ $question->id }}</h5>
                                <p class="card-text" style="font-size:2rem;">{{ $question->answer_count }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
@endsection
