
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

const M = require('materialize-css')

// Navbar search button behavior
const searchElems = document.querySelectorAll('.nav-wrapper li.search')
for (const $elem of searchElems) {
  $elem.addEventListener('click', function(event) {
    const hasFocus = $elem => $elem === document.activeElement
    const isCloseIcon = event.target.classList.contains('material-icons') &&
                        event.target.textContent === 'close' &&
                        hasFocus(this.querySelector('input[type="search"]'))
    if (isCloseIcon) return

    this.classList.add('show')
    const $search = this.querySelector('input[type="search"]')
    if ($search) $search.focus()

    // Not using add event listener for easy removal of
    // the listener
    $search.onblur = () => {
      // did not lose previous this because of arrow function
      this.classList.remove('show')
      $search.onblur = null
    }
  })
}


// Position nav options depending on img width
const $navOptions = document.querySelector('.nav-wrapper > ul')
const $logoImg = document.querySelector('.brand-logo img')

$navOptions.style.paddingLeft = $logoImg.width + 'px'


// Initialize nav dropdowns
const outerDropdown = document.querySelectorAll('nav .dropdown-trigger.dropdown-outer')
M.Dropdown.init(outerDropdown, {
  hover: false,
  constrainWidth: false,
  coverTrigger: false,
})

const nestedDropdown = document.querySelectorAll('nav .dropdown-trigger.dropdown-nested')
for ($elem of nestedDropdown) {
  M.Dropdown.init($elem, {
    hover: true,
    constrainWidth: false,
    coverTrigger: true,
  })
}
