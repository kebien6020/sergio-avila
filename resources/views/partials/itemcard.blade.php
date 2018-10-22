<div class="masonry-item col s6 l4">
  <a href="/item/{{ $item->slug }}">
    <div class="card hoverable">
      <div class="card-image">
        <img src="{!! $item->images->first()->url !!}" alt="Foto del {{ $item->name }}">
      </div>
      <div class="card-content">
        <span class="card-title flow-text">{{ $item->name }}</span>
        <small>{{ $item->code }}</small>
      </div>
    </div>
  </a>
</div>
