@extends('layout')

@section('class', 'search')
@section('js', 'search')

@section('content')

<div class="container">
  <div class="row">
    <section class="category-list col s12 l3">
      <ul class="collapsible">
        <li class="active">
          <div class="collapsible-header">
            <i class="material-icons">ballot</i>
            Sub-categorías
          </div>
          <div class="collapsible-body">
            <div class="collection">
              @foreach ($families as $family)
                <a href="/search?fam=[{{ $family->code }}]" class="collection-item">{{ $family->name }}</a>
              @endforeach
            </div>
          </div>
        </li>
      </ul>
    </section>

    <section class="results col s12 l9">
      <div class="masonry">
        @foreach ($items as $item)
          <div class="masonry-item">
            <a href="/item/{{$item->code}}">
              <div class="card hoverable">
                <div class="card-image">
                  <img src="{!! $item->images->first()->url !!}">
                </div>
                <div class="card-content">
                  <span class="card-title">{{ $item->name }}</span>
                  <small>{{ $item->code }}</small>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </section>
  </div>
</div>

{{-- Masonry layout used only in this view --}}
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
@endsection
