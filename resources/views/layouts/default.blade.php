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
          $className = $parts[0];
      }
      else {
          $className = Route::current()->getName();
      }
  @endphp
  <body class="{{$className}}">
    <main>
        <x-blocks.top-banner />
        <x-blocks.hero />
        <div class="container">
            <div class="content-block">
                @yield("content")
            </div>

            @if(request()->path() === 'contact')
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2473.432987711052!2d5.284448915590253!3d51.68852110526529!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6ee8855f3c5d1%3A0x4c4797f27d227e73!2sOnderwijsboulevard%20215%2C%205223%20DE%20&#39;s-Hertogenbosch!5e0!3m2!1sen!2snl!4v1585055473064!5m2!1sen!2snl" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            @endif
        </div>
        <x-blocks.footer />
    </main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </body>
</html>
