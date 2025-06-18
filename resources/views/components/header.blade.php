<div>
    @foreach($mainMenuItems as $item)
        <a href="{{ $item['url'] }}" class="text-gray-700 hover:text-blue-500">
            {{ $item['name'] }}
        </a>
    @endforeach
</div>
