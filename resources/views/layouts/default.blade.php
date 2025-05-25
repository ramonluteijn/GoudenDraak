<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>{{ config("app.name") }} | @yield("title")</title>
    @vite(['resources/assets/js/app.js'])
  </head>
  @php
      if (strpos(Route::current()->getName(), '.') !== false) {
          $parts = explode('.', Route::current()->getName());
          $className = $parts[1]; // user.events.index -> events
      }
      else {
          $className = Route::current()->getName();
      }
  @endphp
  <body class="{{$className}}">
    <main>
        <x-blocks.top-banner />
        <x-blocks.hero />
        @yield("content")
        <x-blocks.footer />
    </main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </body>
</html>
