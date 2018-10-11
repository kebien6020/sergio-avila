const M = require('materialize-css')
const Masonry = require('masonry')
const imagesloaded = require('imagesloaded')

// Collapsibles
const collapsibles = document.querySelectorAll('.collapsible')
const collapInstance = M.Collapsible.init(collapsibles, {
  accordion: false
})

// on med-and-up expand
const allFamilies = document.querySelector('.collapsible .all-families')
if (window.innerWidth > 992) {
  collapInstance[0].open(1)
}

// Masonry
const masonry = new Masonry( '.results .masonry', {
  itemSelector: '.masonry-item',
  columnWidth: '.masonry-item',
  percentPosition: true,
});

let imgLoad = imagesloaded('.results .masonry')
const reLayout = () => masonry.layout()
imgLoad.on('progress', reLayout)


// Infinite scroll

let lastKnownScrollPosition = 0
let ticking = false
let pageToLoad = 2
let loading = false

imgLoad.on('always', registerScrollListener)

function registerScrollListener() {
  window.addEventListener('scroll', e => {
    lastKnownScrollPosition = window.scrollY

    if (!ticking) {
      window.requestAnimationFrame(() => {
        checkInfiniteScroll(lastKnownScrollPosition)
        ticking = false
      })

      ticking = true
    }
  })
}

function checkInfiniteScroll(scrollTop) {
  const scrollBottom = scrollTop + window.innerHeight
  const distanceToBottom = document.body.scrollHeight - scrollBottom
  if (distanceToBottom < 1000 && !loading && pageToLoad !== null) {
    loading = true
    loadPage()
  }
}

const target = document.querySelector('.results .masonry')
async function loadPage() {
  try {
    const search = window.location.search.slice(1) // slice ? from the beginning
    const parsedSearch = search
      .split('&')
      .map(s => s.split('='))
      .filter(([key]) => key !== '')
      .reduce((obj, arr) => (obj[arr[0]] = arr[1], obj), {})

    parsedSearch.page = pageToLoad
    const newSearch = '?' + Object.entries(parsedSearch)
      .map(keyValArr => keyValArr.join('='))
      .join('&')

    const res = await fetch(`/partials/items${newSearch}`)
    const partial = await res.text()

    if (partial === '') {
      pageToLoad = null
      return
    }

    const tempContainer = document.createElement('div')
    tempContainer.innerHTML = partial

    for (const elem of tempContainer.children)
      target.append(elem)

    masonry.appended(tempContainer.children)
    const items = masonry.addItems(tempContainer.children)
    masonry.reloadItems()

    // Rebind imagesloaded on progress
    imgLoad.off('progress')
    imgLoad = imagesloaded('.results .masonry')
    imgLoad.on('progress', reLayout)

    ++pageToLoad
  } finally {
    loading = false
  }
}
