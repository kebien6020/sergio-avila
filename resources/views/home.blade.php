@extends('layout')

@section('class', 'home')
@section('js', 'home')

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
      ['Agendas', 'agendas', 'fam' => [3]],
      ['Bebidas', 'bebidas', [
        ['Botilitos', 'botilitos', 'fam' => [15, 16]],
        ['Mugs, Tazas y Vasos', 'mugs', 'fam' => [33, 34, 35]],
      ]],
      ['Bienestar', 'bienestar', [
        ['Anti-stress', 'anti-stress', 'fam' => [4]],
        ['Belleza', 'belleza', 'fam' => [9]],
        ['Salud', 'salud', 'fam' => [32]],
      ]],
      ['Herramientas', 'herramientas', 'fam' => [18]],
      ['Hogar', 'hogar', [
        ['Bar', 'bar', 'fam' => [8]],
        ['Hogar', 'hogar', 'fam' => [20]],
        ['Relojes y Portarretratos', 'relojes', 'fam' => [30, 31]],
      ]],
      ['Niños', 'ninos', 'fam' => [27]],
      ['Oficina', 'oficina', [
        ['Boligrafos', 'boligrafos', 'fam' => [10, 11, 12]],
        ['Libretas y Carpetas', 'libretas', 'fam' => [14, 22]],
        ['Llaveros', 'llaveros', 'fam' => [23, 24]],
        ['Oficina', 'oficina', 'fam' => [5]],
      ]],
      ['Tecnología', 'tecnologia', [
        ['Accesorios de cómputo y USB', 'acc-computo', 'fam' => [1, 36]],
        ['Accesorios de smartphone y tablet', 'acc-cel', 'fam' => [2]],
        ['Audio y bocinas', 'audio', 'fam' => [7]]
      ]],
      ['Textiles', 'textiles', [
        ['Bolsas', 'bolsas', 'fam' => [13]],
        ['Gorras', 'gorras', 'fam' => [17]],
        ['Hieleras y loncheras', 'loncheras', 'fam' => [19]],
        ['Maletas', 'maletas', 'fam' => [25]],
        ['Mochilas', 'mochilas', 'fam' => [26]],
        ['Paraguas', 'paraguas', 'fam' => [28]],
        ['Portafolios', 'portafolios', 'fam' => [29]],
      ]],
      ['Viaje', 'viaje', 'fam' => [6]],
    ];

    function genCategLinkTagOpen($categ) {
      if (!array_key_exists('fam', $categ)) {
        return '';
      }
      return '<a href="/search?fam=' . collect($categ['fam'])->toJson(). '">';
    }

    function genCategLinkTagClose($categ) {
      if (!array_key_exists('fam', $categ)) {
        return '';
      }
      return '</a>';
    }
  ?>
  <div class="row">
    @foreach ($categs as $categ)
      {!! genCategLinkTagOpen($categ) !!}
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
                    {!! genCategLinkTagOpen($subcateg) !!}
                      <div class="card hoverable">
                        <div class="card-image">
                          <img src="images/categ-{{$subcateg[1]}}.jpg">
                        </div>
                        <div class="card-content">
                          <span class="card-title">{{$subcateg[0]}}</span>
                        </div>
                      </div>
                    {!! genCategLinkTagClose($subcateg) !!}
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      {!! genCategLinkTagClose($categ) !!}
    @endforeach
  </div>
</section>

<section id="contact">
  <div class="parallax-container">
    <div class="parallax"><img src="/images/contact-bg.jpg"></div>
    <div class="row">
      <div class="card-panel white col s12 m8 offset-m2 l6 offset-l3">
        <div class="row">
          <div class="title col s10 offset-s1">
            <h4 class="card-panel">Contactenos</h4>
          </div>
        </div>
        <form action="https://formspree.io/kevin.pena.prog@gmail.com" method="post">
          <div class="row">
            <div class="input-field col s12 m6">
              <input
                id="first_name"
                name="first_name"
                type="text"
                class="validate"
                required
                placeholder="Nombre">
              <label for="first_name">Nombre</label>
            </div>
            <div class="input-field col s12 m6">
              <input
                id="last_name"
                name="last_name"
                type="text"
                class="validate"
                placeholder="(Opcional)">
              <label for="last_name">Apellido</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input
                id="email"
                name="email"
                type="email"
                class="validate"
                required
                placeholder="A esta dirección contestaremos tu mensaje"
              >
              <label for="email">Correo Electrónico</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input
                id="tel"
                name="tel"
                type="tel"
                class="validate"
                required
                placeholder="(Opcional)"
              >
              <label for="tel">Celular</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea
                id="mensaje"
                name="mensaje"
                class="materialize-textarea char-counted validate"
                placeholder="Ingresa el comentario que nos quieres hacer llegar"
                data-length="400"
                required
              ></textarea>
              <label for="mensaje">Mensaje</label>
            </div>
          </div>
          <div class="row">
            <button class="col s6 offset-s3 m4 offset-m4 btn waves-effect waves-light" type="submit">Enviar
              <i class="material-icons right">send</i>
            </button>
          </div>
          <input type="hidden" name="_next" value="/?message-sent=1">
        </form>
      </div>
    </div>
  </div>
</section>


{{-- Message sent modal --}}
<div id="message-sent-modal" class="modal">
  <div class="modal-content">
    <h4>Mensaje enviado</h4>
    <p>Gracias por contactarnos</p>
    <p></p>
    <p>Tu mensaje fue enviado exitosamente. <br>Responderemos tu consulta lo mas pronto posible.</p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
  </div>
</div>

@endsection
