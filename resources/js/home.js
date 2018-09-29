// Code specific to the home view

const M = require('materialize-css')

// About parallax
const parallaxElems = document.querySelectorAll('.parallax')
M.Parallax.init(parallaxElems)

// Card expansion
const outerCards = document.querySelectorAll('.card-outer')
const scrim = document.getElementById('scrim')
for ($elem of outerCards) {
  $elem.addEventListener('click', function(event) {
    const inner = this.querySelector('.subcategory-container')
    if (!inner) return
    inner.style.display = 'flex'

    event.preventDefault()

    // Convert to position fixed before animation
    const xCoord = this.offsetLeft - window.pageXOffset
    const yCoord = this.offsetTop - window.pageYOffset
    const width = this.clientWidth
    const height = this.clientHeight
    this.style.position = 'fixed'
    this.style.left = xCoord + 'px'
    this.style.top = yCoord + 'px'
    this.style.width = width + 'px'
    this.style.height = height + 'px'

    const img = this.querySelector('.card-image img')
    if (img) {
      img.parentElement.style.height = img.height + 'px'
    }

    setTimeout(() => {
      this.classList.remove('hoverable')
      this.classList.add('z-depth-5')
      this.classList.add('expanded')
      this.style.zIndex = 200;
      //
      scrim.classList.add('show')
    }, 0)

  })
}

scrim.addEventListener('click', () => {
  scrim.classList.remove('show')
  for ($elem of outerCards) {
    $elem.classList.add('hoverable')
    $elem.classList.remove('z-depth-5')
    $elem.classList.remove('expanded')

    $elem.removeAttribute('style')

    setTimeout(() => {
      const img = $elem.querySelector('.card-image img')
      if (img) {
        img.parentElement.style.height = img.height + 'px'
      }
    }, 300)

    const inner = $elem.querySelector('.subcategory-container')
    if (inner) inner.style.display = 'none'
  }
})
