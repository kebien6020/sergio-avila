@extends ('layout')

@section('class', 'item')
@section('js', 'item')

@section('content')

<div class="container">

  {{-- Breadcrumbs --}}
  <div class="breadcrumbs row">
    <div class="col s12">
      <a href="/#categories" class="breadcrumb">CATEGORÍAS</a>
      <a href="/search?fam=[{{$item->family_code}}]" class="breadcrumb">
        {{ $item->family->name }}
      </a>
      <span class="breadcrumb">{{ $item->code }}</span>
    </div>
  </div>

  <div class="row">
    <div class="col s12 l4">
      <div class="slider card">
        <ul class="slides">
          @foreach ($item->images as $image)
            <li><img class="materialboxed" src="{!! $image->url !!}" alt="Foto del artículo {{ $item->name }}"></li>
          @endforeach
        </ul>
      </div>
      @if ($item->images->count() > 1)
        <ul class="thumbs row">
          @foreach ($item->images as $image)
            <li class="col s6 m4 l6 xl4">
              <div
                class="thumb-img card hoverable"
                data-num="{{ $loop->index }}"
                role="img"
                aria-label="Miniatura de imágenes del artículo"
                style="background-image: url({{ $image->url }});"></div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    <div class="descr col s12 l8">
      <h3>{{ $item->name }}</h3>
      <small id="item-code" class="flow-text">{{ $item->code }}</small>

      <h4>Descripción</h4>
      <div class="divider"></div>
      <p class="flow-text">
        {{ $item->description_1 }}
        @if($item->description_2 !== '')
          ({{ $item->description_2 }})
        @endif
      </p>

      <div class="existences card-panel valign-wrapper">
        <i class="material-icons">archive</i>
        <p id="existence-msg"></p>
      </div>
      <div class="existences-error card-panel valign-wrapper">
        <i class="material-icons">error</i>
        <p id="existence-error-msg"></p>
      </div>

      @if ($moreColors->count() > 0)
        <h4>Otros colores</h4>
        <div class="divider"></div>
        <div class="more-colors masonry row">
          @foreach($moreColors as $relItem)
            <div class="card-wrapper masonry-item col s6 m4 l3">
              <a href="/item/{{ str_replace(' ', '_', $relItem->code) }}">
                <div class="card hoverable">
                  <div class="card-image">
                    <img src="{!! $relItem->images->first()->url !!}" alt="Artículo en color {{ $relItem->color }}">
                  </div>
                  <div class="card-content">
                    <p>{{ $relItem->name }}</p>
                    <small>{{ $relItem->code }}</small>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      @endif

      <h4>Detalles</h4>
      <div class="divider"></div>
      <table class="striped">
        <?php
          use \Illuminate\Support\HtmlString;
          function renderRow($text, $value) {
            return new HtmlString(
              '<tr><td>' . e($text) . '</td><td>' . e($value) . '</td>'
            );
          }
        ?>
        <tr></tr> {{-- Iniciar en la fila blanca --}}
        <tr><th colspan="2">INFORMACIÓN BÁSICA</th></tr>

        {{ renderRow('CATEGORÍA', $item->family->name) }}
        {{ renderRow('MATERIAL', $item->material) }}
        {{ renderRow('TAMAÑO', $item->size) }}
        {{ renderRow('COLOR', $item->color) }}
        {{ renderRow('CAPACIDAD', $item->capacity) }}

        <tr><th colspan="2">INFORMACIÓN DE IMRESIÓN</th></tr>

        {{ renderRow('TÉCNICA', $item->print_technique) }}
        {{ renderRow('ÁREA', $item->print_area) }}

        <tr><th colspan="2">INFORMACIÓN DE EMPAQUE</th></tr>

        <?php $l = floatval($item->length) * 100 ?>
        <?php $h = floatval($item->height) * 100?>
        <?php $w = floatval($item->width) * 100?>
        {{ renderRow('MEDIDA', "$l x $h x $w cm.") }}
        {{ renderRow('PESO', $item->weight . 'kg.') }}
        {{ renderRow('CANTIDAD', $item->qty_packing . ' pza(s).') }}
        {{ renderRow('INDIVIDUAL BOX', '') }}

      </table>
    </div>
  </div>

</div>

{{-- Masonry layout specific to this view --}}
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>

@endsection
