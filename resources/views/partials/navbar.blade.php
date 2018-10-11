<nav aria-role="navigation">
  <div class="nav-wrapper blue darken-2">
    <a href="/" class="brand-logo">
      {{-- <img src="/images/logo.png" alt="Logo de la Empresa"> --}}
      <object type="image/svg+xml" data="/images/logo.svg">
        Su navegador no soporta SVG
      </object>
      <span class="whatsapp">
        305 717 3218
        <span class="fab fa-whatsapp"></span>
      </span>
    </a>
    <a href="#" data-target="sidenav-mobile" class="sidenav-trigger">
      <i class="material-icons">menu</i>
    </a>
    <ul id="nav-mobile">
      <li><a href="/#categories">Categorías</a></li>
      <li><a href="/search">Catálogo</a></li>
    </ul>
    <ul class="search-btn-container">
      <li><a href="#!"><i class="material-icons">search</i></a></li>
    </ul>

    {{-- Search form --}}
    <div class="search-bar">
      <form>
        <div class="input-field">
          <input id="search" type="search" required autocomplete="off">
          <label class="label-icon" for="search"><i class="material-icons">search</i></label>
          <i class="material-icons search-btn-close">close</i>
        </div>
      </form>
    </div>

  </div>
  <ul class="sidenav" id="sidenav-mobile">
    <li><a href="/#categories">Categorías</a></li>
    <li><a href="/search">Catálogo</a></li>
  </ul>
</nav>
