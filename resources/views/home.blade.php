@extends('layout')

@section('name', 'home')

@section('content')

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
      ['Bebidas', 'bebidas', [
        ['Botilitos', 'botilitos'],
        ['Mugs, Tazas y Vasos', 'mugs'],
      ]],
      ['Bienestar', 'bienestar', [
        ['Anti-stress', 'anti-stress'],
        ['Belleza', 'belleza'],
        ['Salud', 'salud'],
      ]],
      ['Herramientas', 'herramientas'],
      ['Hogar', 'hogar', [
        ['Bar', 'bar'],
        ['Hogar', 'hogar'],
        ['Relojes y Portarretratos', 'relojes'],
      ]],
      ['Niños', 'ninos'],
      ['Oficina', 'oficina', [
        ['Boligrafos', 'boligrafos'],
        ['Libretas y Carpetas', 'libretas'],
        ['Llaveros', 'llaveros'],
        ['Oficina', 'oficina'],
      ]],
      ['Tecnología', 'tecnologia', [
        ['Accesorios de cómputo y USB', 'acc-computo'],
        ['Accesorios de smartphone y tablet', 'acc-cel'],
        ['Audio y bocinas', 'audio']
      ]],
      ['Textiles', 'textiles', [
        ['Bolsas', 'bolsas'],
        ['Gorras', 'gorras'],
        ['Hieleras y loncheras', 'loncheras'],
        ['Maletas', 'maletas'],
        ['Mochilas', 'mochilas'],
        ['Paraguas', 'paraguas'],
        ['Portafolios', 'portafolios'],
      ]],
      ['Viaje', 'viaje'],
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

@endsection
