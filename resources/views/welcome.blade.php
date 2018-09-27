<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sergio Avila</title>

        {{-- Fonts --}}
        {{-- Google Icon Font --}}
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        {{-- Styles --}}
        {{-- Main styles --}}
        <link type="text/css" rel="stylesheet" href="css/vendor.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/app.css"  media="screen,projection"/>

    </head>
    <body>
      <header>
        <nav aria-role="navigation">
          <div class="nav-wrapper grey darken-4">
            <a href="#" class="brand-logo">
              <img src="/images/logo.png" alt="Logo de la Empresa">
            </a>
            <a href="#" data-target="sidenav-mobile" class="sidenav-trigger">
              <i class="material-icons">menu</i>
            </a>
            <ul id="nav-mobile">
              <li><a href="#">Catálogo</a></li>
              <li><a href="#">Categorías</a></li>
              <li class="search">
                <a href="#">
                  <form>
                    <div class="input-field">
                      <input id="search" type="search">
                      <label class="label-icon" for="search">
                        <i class="material-icons">search</i>
                      </label>
                      <i class="material-icons">close</i>
                    </div>
                  </form>
                </a>
              </li>
            </ul>
          </div>

          <ul class="sidenav" id="sidenav-mobile">
            <li><a href="#">Catálogo</a></li>
            <li><a href="#">Categorías</a></li>
          </ul>
        </nav>
      </header>



      {{-- Scripts --}}
      {{-- CDN --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
      {{-- Main --}}
      {{-- <script src="/js/manifest.js" type="text/javascript" charset="utf-8"></script> --}}
      {{-- <script src="/js/vendor.js" type="text/javascript" charset="utf-8"></script> --}}
      <script src="/js/app.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
