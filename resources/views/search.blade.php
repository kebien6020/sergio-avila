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
        @if ($families->count() >= 5)
          MULTIPLES CATEGORÍAS
        @else
          {{ $families->pluck('name')->implode(', ') }}
        @endif
      </span>
    </div>
  </div>

  <div class="row">
    <section class="category-list col s12 l3">
      <ul class="collapsible expandable">
        <li class="active">
          <div class="collapsible-header">
            <i class="material-icons">ballot</i>
            Sub-categorías
            <div class="expand-icon">
              <i class="material-icons on-active">expand_less</i>
              <i class="material-icons on-inactive">expand_more</i>
            </div>
          </div>
          <div class="collapsible-body">
            <div class="collection">
              @foreach ($families as $family)
                <a href="/search?fam=[{{ $family->code }}]" class="collection-item">{{ $family->name }}</a>
              @endforeach
            </div>
          </div>
        </li>
        <li class="all-families">
          <div class="collapsible-header">
            <i class="material-icons">category</i>
            Todas las categorías
            <div class="expand-icon">
              <i class="material-icons on-active">expand_less</i>
              <i class="material-icons on-inactive">expand_more</i>
            </div>
          </div>
          <div class="collapsible-body">
            <div class="collection">
              @foreach ($allFamilies as $family)
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
          @include('partials/itemcard')
        @endforeach
      </div>
    </section>
  </div>
</div>

{{-- Masonry layout specific to this view --}}
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
@endsection
