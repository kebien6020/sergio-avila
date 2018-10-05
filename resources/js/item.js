const M = require('materialize-css')
const Masonry = require('masonry')
const imagesloaded = require('imagesloaded')

function sliderResponsiveHeight() {
  let res = 350
  if (window.innerWidth > 450) res = 450
  if (window.innerWidth > 600) res = 500
  if (window.innerWidth > 800) res = 600
  if (window.innerWidth > 992) res = 350

  return res
}

const sliderElem = document.querySelectorAll('.slider')
const sliderOpts = {
  indicators: false,
  duration: 300,
  height: sliderResponsiveHeight(),
}
let sliders = M.Slider.init(sliderElem, sliderOpts)

// Resize slider resposively on resize, debouncing with requestAnimationFrame

let timeout
window.addEventListener('resize', function ( event ) {
	// If there was a previous timer, cancel it
	if (timeout)
		window.cancelAnimationFrame(timeout)

  // Schedule slider resize on the next animation frame
	timeout = window.requestAnimationFrame(() => {
    const height = sliderResponsiveHeight()

    // If we are not going to change anything abort
    if (height === sliders[0].options.height)
      return

    for (const slider of sliders)
      slider.destroy()
    sliders = M.Slider.init(sliderElem, {...sliderOpts, height})

	})

}, false)

const thumbnails = document.querySelectorAll('.thumb-img')
for (const $thumb of thumbnails) {
  $thumb.addEventListener('mouseenter', () => {
    for (const slider of sliders)
      slider.set($thumb.dataset.num)
  })
}

// Material box for the image

const matBoxImages = document.querySelectorAll('.materialboxed')
M.Materialbox.init(matBoxImages, {
  onOpenStart() {
    for (const slider of sliders) slider.pause()
  },
  onCloseEnd() {
    for (const slider of sliders) slider.start
  }
})

// Masonry

const masonry = new Masonry('.masonry', {
  itemSelector: '.masonry-item',
  columnWidth: '.masonry-item',
  percentPosition: true,
});

imagesloaded('.masonry').on('progress', () => masonry.layout())

// Existences

async function fetchExistences() {
  const itemCode = document.getElementById('item-code').textContent
  try {
    const res = await fetch('/api/existences/' + itemCode)
    const data = await res.json()

    if (!data.success) {
      console.error('Error de SOAP', data)
      return handleError()
    }

    const existence = data.Existencia

    const $exMsg = document.getElementById('existence-msg')
    const num = String(Number(existence.Stok))
    $exMsg.textContent = `Tenemos ${num} en stock.`

    document.querySelector('.existences').classList.add('show')
  } catch (err) {
    return handleError()
  }


  function handleError() {
    const $exErrorMsg = document.getElementById('existence-error-msg')
    $exErrorMsg.textContent = 'Error al consultar existencias.'

    document.querySelector('.existences-error').classList.add('show')
  }

}

fetchExistences()
