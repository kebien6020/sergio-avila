<nav aria-role="navigation">
  <div class="nav-wrapper grey darken-4">
    <a href="/" class="brand-logo">
      <img src="/images/logo.png" alt="Logo de la Empresa">
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
          <input id="search" type="search" required>
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
