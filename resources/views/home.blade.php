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
        @include('partials/navbar')
      </header>

      <main>
        <section class="about">
          <div class="parallax-container">
            <div class="parallax"><img src="/images/about-bg.jpg"></div>
            <div class="about-text">
              <h3>Sobre nosotros</h3>
              <h5>Texto sobre nosotros</h5>
            </div>
          </div>
        </section>
        <section id="categories">
          <h3>Categorías</h3>
          <?php
            $categs = [
              ['Agendas', 'agendas'],
              ['Bebidas', 'bebidas'],
              ['Bienestar', 'bienestar', [
                  ['Anti-stress', 'anti-stress'],
                  ['Belleza', 'belleza'],
                  ['Salud', 'salud'],
              ]],
              ['Herramientas', 'herramientas'],
              ['Hogar', 'hogar'],
              ['Niños', 'ninos'],
              ['Oficina', 'oficina'],
              ['Tecnología', 'tecnologia'],
              ['Textiles', 'textiles'],
              ['Tiempo Libre', 'tiempo-libre'],
            ]
          ?>
          <div class="row">
            @foreach ($categs as $categ)
              <a href="#">
                <div class="col s6 m4 l3">
                  <div class="card hoverable card-outer">
                    <div class="card-image">
                      <img src="images/categ-{{$categ[1]}}.jpg">
                    </div>
                    <div class="card-content">
                      <span class="card-title">{{$categ[0]}}</span>
                    </div>
                    @if (array_key_exists(2, $categ))
                      <div class="subcategory-container">
                          @foreach ($categ[2] as $subcateg)
                            <div class="inner-card-wrapper">
                              <div class="card hoverable">
                                <div class="card-image">
                                  <img src="images/categ-{{$subcateg[1]}}.jpg">
                                </div>
                                <div class="card-content">
                                  <span class="card-title">{{$subcateg[0]}}</span>
                                </div>
                              </div>
                            </div>
                          @endforeach
                      </div>
                    @endif
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </section>
      </main>


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
      <script src="/js/home.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
