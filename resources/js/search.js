const M = require('materialize-css')
const Masonry = require('masonry')
const imagesloaded = require('imagesloaded')

const collapsibles = document.querySelectorAll('.collapsible')
M.Collapsible.init(collapsibles)

const masonry = new Masonry( '.results .masonry', {
  itemSelector: '.masonry-item',
  columnWidth: '.masonry-item',
  percentPosition: true,
});

imagesloaded('.results .masonry').on('progress', () => masonry.layout())
