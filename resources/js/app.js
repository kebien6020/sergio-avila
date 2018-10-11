
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

const M = require('materialize-css')
const axios = require('axios')

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

// Sidenav
const sidenavTriggers = document.querySelectorAll('.sidenav')
M.Sidenav.init(sidenavTriggers)


// Position nav options depending on img width
const $navOptions = document.querySelector('.nav-wrapper > ul')
const $logoImg = document.querySelector('.brand-logo img')

$navOptions.style.paddingLeft = $logoImg.width + 'px'

// Search bar

// Search button
const searchBtn = document.querySelector('.search-btn-container a')
const closeBtn = document.querySelector('.search-btn-close')
const searchBar = document.querySelector('.search-bar')
const searchInput = document.querySelector('input#search')

searchBtn.addEventListener('click', (event) => {
  event.preventDefault()

  searchBar.style.display = 'block'
  setTimeout(() => searchBar.classList.add('show') , 0)
  searchInput.focus()
})

function closeSearchBar() {

  searchBar.classList.remove('show')

  setTimeout(() => searchBar.style.display = '', 400)
}

closeBtn.addEventListener('click', closeSearchBar)
searchInput.addEventListener('blur', closeSearchBar)

// Search functionality

// Modify dropdown filtering

// Adapted from:
// https://github.com/Dogfalo/materialize/blob/ac5c80e330321ea04d87bdbe9b204d565ebf246c/js/autocomplete.js#L344
const renderDropdownModified = function(data, val) {
  const $ = window.cash
  this._resetAutocomplete();

  let matchingData = [];

  // Gather all matching data

  //
  // Another modification
  //
  this.count = 0
  for (let key in data) {
    //
    // Here is the modification
    //
    if (data.hasOwnProperty(key) /* && key.toLowerCase().indexOf(val) !== -1 */) {
      // Break if past limit
      if (this.count >= this.options.limit) {
        break;
      }

      let entry = {
        data: data[key],
        key: key
      };
      matchingData.push(entry);

      this.count++;
    }
  }
  // Sort
  if (this.options.sortFunction) {
    let sortFunctionBound = (a, b) => {
      return this.options.sortFunction(
        a.key.toLowerCase(),
        b.key.toLowerCase(),
        val.toLowerCase()
      );
    };
    matchingData.sort(sortFunctionBound);
  }

  // Render
  for (let i = 0; i < matchingData.length; i++) {
    let entry = matchingData[i];
    let $autocompleteOption = $('<li></li>');
    if (!!entry.data) {
      $autocompleteOption.append(
        `<img src="${entry.data}" class="right circle"><span>${entry.key}</span>`
      );
    } else {
      $autocompleteOption.append('<span>' + entry.key + '</span>');
    }

    $(this.container).append($autocompleteOption);
    // Highlight doesn't work on multiple matches
    // and it messes up the rendered text

    // this._highlight(val, $autocompleteOption);
  }
}

M.Autocomplete.prototype._renderDropdown = renderDropdownModified

const autoCompleteInstace = M.Autocomplete.init(searchInput, {
  data: {},
  limit: 15,
  sortFunction: false,
  onAutocomplete(name) {
    const fullData = autoCompleteInstace.options.data[Symbol.for('FULLDATA')]
    const items = fullData.filter(item => item.name === name)

    if (items.length > 0) {
      const code = items[0].code
      window.location.href = '/item/' + code.replace(' ', '_')
    }
  }
})

// Taken from:
// https://codeburst.io/throttling-and-debouncing-in-javascript-646d076d0a44
function debounced(delay, fn) {
  let timerId;
  return function (...args) {
    if (timerId) {
      clearTimeout(timerId);
    }
    timerId = setTimeout(() => {
      fn(...args);
      timerId = null;
    }, delay);
  }
}

function getSuggestions(text) {
  return axios.get('/api/autosuggest', {
    params: { term: text }
  })
}

// Get suggestions while writing (debounced)
searchInput.addEventListener('input', debounced(300, async (event) => {
  const text = event.target.value
  if (typeof text !== 'string')
    return

  const suggestions = await getSuggestions(text)
  const data = suggestions.data.reduce((obj, sug) =>
    (obj[sug.name] = sug.image, obj) // comma operator
  , {})

  // Hide fulldata inside normal data object
  data[Symbol.for('FULLDATA')] = suggestions.data

  autoCompleteInstace.updateData(data)
  autoCompleteInstace.open()
}))

// On submit select the first element
const searchForm = document.querySelector('.search-bar form')
searchForm.addEventListener('submit', (event) => {
  event.preventDefault()

  const fullData = autoCompleteInstace.options.data[Symbol.for('FULLDATA')]

  if (fullData.length > 0) {
    autoCompleteInstace.options.onAutocomplete(fullData[0].name)
  }
})
