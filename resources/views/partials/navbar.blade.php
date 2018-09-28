<?php
  // Custom PHP for rendering the list of options of the navbar

  // This is the raw data used to build the structure of nested `ul`s, a list
  // consists of an id, and an array of items. An item consists of a text
  // for displaying, a link and optionally an inner list.
  $options = [
    'id' => 'nav-mobile',
    [
      'text' => 'Catálogo',
      'link' => '#',
      'innerItems' => [
        'id' => 'catalog-dropdown',
        [
          'text' => 'Busqueda Avanzada',
          'link' => '#',
        ],
        [
          'text' => 'Por Categoría',
          'link' => '#',
          'innerItems' => [
            'id' => 'category-dropdown',
            [
              'text' => 'Agendas',
              'link' => '#'
            ],
            [
              'text' => 'Bebidas',
              'link' => '#'
            ],
          ]
        ],
        [
          'text' => 'Digitales',
          'link' => '#',
        ],
      ],
    ],
    [
      'text' => 'Categorías',
      'link' => '#',
    ],
  ];

  function renderList($data, $level = 1) {

    // ul opening tag

    $str = '<ul id="' . $data['id'] . '"';

    if ($level === 2) {
      $str .= ' class="dropdown-content dropdown-outer"';
    } elseif ($level >= 3) {
      $str .= ' class="dropdown-content dropdown-nested"';
    }
    $str .= '>';

    // li with inner link and inner list if it applies
    foreach ($data as $key => $item) {
      if(!is_int($key))
        continue;
      $str .= '<li>';
      $str .= '<a href="' . $item['link'] . '"';
      if (array_key_exists('innerItems', $item)) {
        $triggerClass = $level === 1 ? 'dropdown-outer' : 'dropdown-nested';
        $str .= ' class="dropdown-trigger ' . $triggerClass . '"';
        $str .= ' data-target="' . $item['innerItems']['id'] . '"';
      }
      $str .= '>' . $item['text'] . '</a>';

      if (array_key_exists('innerItems', $item)) {
        $str .= renderList($item['innerItems'], $level + 1);
      }
      $str .= '</li>';
    }
    $str .= '</ul>';

    return $str;
  }

?>


<nav aria-role="navigation">
  <div class="nav-wrapper grey darken-4">
    <a href="#" class="brand-logo">
      <img src="/images/logo.png" alt="Logo de la Empresa">
    </a>
    <a href="#" data-target="sidenav-mobile" class="sidenav-trigger">
      <i class="material-icons">menu</i>
    </a>
    {!! renderList($options) !!}
  <ul class="sidenav" id="sidenav-mobile">
    <li><a href="#">Catálogo</a></li>
    <li><a href="#">Categorías</a></li>
  </ul>
</nav>
