@foreach($mainMenuItems as $item)
    <a href="{{ $item['url'] }}" class="">
        {{ $item['name'] }}
    </a>
@endforeach
