@extends('layout')

@section('class', 'search')
@section('js', 'search')

@section('content')

<div class="container">
  {{-- Breadcrumbs --}}
  <div class="breadcrumbs row">
    <div class="col s12">
      <a href="/#categories" class="breadcrumb">CATEGORÍAS</a>
      <span class="breadcrumb">
        {{ $families->pluck('name')->implode(', ') }}
      </span>
    </div>
  </div>

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
      <div class="masonry row">
        @foreach ($items as $item)
          <div class="masonry-item col s6 l4">
            <a href="/item/{{ str_replace(' ', '-', $item->code) }}">
              <div class="card hoverable">
                <div class="card-image">
                  <img src="{!! $item->images->first()->url !!}">
                </div>
                <div class="card-content">
                  <span class="card-title flow-text">{{ $item->name }}</span>
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

{{-- Masonry layout specific to this view --}}
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
@endsection
