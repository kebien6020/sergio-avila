const M = require('materialize-css')

const sliderElem = document.querySelectorAll('.slider')
const sliders = M.Slider.init(sliderElem, {
  indicators: false,
  duration: 300,
})

for (const slider of sliders)
  slider.pause()

const thumbnails = document.querySelectorAll('.thumb-img')
for (const $thumb of thumbnails) {
  $thumb.addEventListener('mouseenter', () => {
    for (const slider of sliders)
      slider.set($thumb.dataset.num)
  })
}
