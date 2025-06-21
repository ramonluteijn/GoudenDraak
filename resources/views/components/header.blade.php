    @foreach($mainMenuItems as $item)
        <a href="{{ $item['url'] }}">
            {{ $item['name'] }}
        </a>
    @endforeach
        @if (auth()->check())
            <a href="{{ route('shop.shoppingcart.index') }}">
                Winkelwagen
            </a>
            <a href="{{ route('orders.index') }}">
                Orders
            </a>
            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit">Logout</button>
            </form>

        @else
            <a href="{{ route('login') }}">Login</a>
        @endif

