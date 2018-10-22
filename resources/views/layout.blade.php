<!doctype html>
<html lang="{{ app()->getLocale() }}" class="@yield('class', '')">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Favicon --}}
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="apple-mobile-web-app-title" content="Promo Print">
        <meta name="application-name" content="Promo Print">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Promo Print</title>

        {{-- Fonts --}}
        {{-- Fonts awesome --}}
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        {{-- Google Icon Font --}}
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        {{-- Garamond --}}
        <link href="https://fonts.googleapis.com/icon?family=EB+Garamond" rel="stylesheet">
        {{-- Optima --}}
        <link href="/fonts/optima.css" rel="stylesheet">

        {{-- Styles --}}
        {{-- Main styles --}}
        <link type="text/css" rel="stylesheet" href="/css/vendor.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="/css/app.css"  media="screen,projection"/>

    </head>
    <body>
      <header>
        @include('partials/navbar')
      </header>

      <main>
        @yield('content')
      </main>

      @include('partials/footer')


      {{-- Utility tags --}}
      <div id='scrim'></div>

      {{-- Scripts --}}
      {{-- CDN --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
      {{-- Main --}}
      {{-- <script src="/js/manifest.js" type="text/javascript" charset="utf-8"></script> --}}
      {{-- <script src="/js/vendor.js" type="text/javascript" charset="utf-8"></script> --}}
      <script src="/js/app.js" type="text/javascript" charset="utf-8"></script>

      {{-- View specific js --}}
      @if(array_key_exists('js', View::getSections()))
        <script src="/js/@yield('js').js" type="text/javascript" charset="utf-8"></script>
      @endif
    </body>
</html>
