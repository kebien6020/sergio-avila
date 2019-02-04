// Code specific to the home view

const M = require('materialize-css')

// About and contact parallax
const parallaxElems = document.querySelectorAll('.parallax')
M.Parallax.init(parallaxElems)

// Contact character counter
const counted = document.querySelectorAll('.char-counted')
M.CharacterCounter.init(counted)

// Card expansion
const outerCards = document.querySelectorAll('.card-outer')
const scrim = document.getElementById('scrim')
for (const $elem of outerCards) {
  $elem.addEventListener('click', function(event) {
    const inner = this.querySelector('.subcategory-container')
    if (!inner) return
    inner.style.display = ''

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
      img.parentElement.style.height = '0'
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
  for (const $elem of outerCards) {
    if (!$elem.classList.contains('expanded')) continue
    $elem.classList.add('hoverable')
    $elem.classList.remove('z-depth-5')
    $elem.classList.remove('expanded')

    $elem.removeAttribute('style')

    // Using closure to preserve $elem since the loop ends before the
    // callback to setTimeout triggers
    setTimeout((($elem) => (() => {
      const img = $elem.querySelector('.card-image img')
      if (img) {
        img.parentElement.style.height = 'auto'
      }
    }))($elem), 200)

    const inner = $elem.querySelector('.subcategory-container')
    if (inner) inner.style.display = 'none'
  }
})

// Open message sent modal

const modalElems = document.querySelectorAll('.modal')
M.Modal.init(modalElems, {
  onCloseEnd() {
    // Remove get parameter without reloading the page
    window.history.replaceState({}, '', '/')
  }
})

const $messageSentModal = document.getElementById('message-sent-modal')
const sentModal = M.Modal.getInstance($messageSentModal)

const search = window.location.search.slice(1) // slice ? from the beginning
const parsedSearch = search
  .split('&')
  .map(s => s.split('='))
  .filter(([key]) => key !== '')
  .reduce((obj, arr) => (obj[arr[0]] = arr[1], obj), {})

if (parsedSearch['message-sent']) {
  sentModal.open()
}

// Contact form

const form = document.getElementById('contact-form')
form.addEventListener('submit', (event) => {
  event.preventDefault()

  const firstName = form.querySelector('[name=first_name]').value
  const lastName = form.querySelector('[name=last_name]').value
  const email = form.querySelector('[name=email]').value
  const tel = form.querySelector('[name=tel]').value
  const msg = form.querySelector('[name=mensaje]').value
  const captchaToken = form.querySelector('[name=g-recaptcha-response]').value

  const data = new FormData()

  data.append('custom_U2764', firstName + ' ' + lastName)
  data.append('Email', email)
  data.append('custom_U2759', `Tel: ${tel}\n${msg}`)
  data.append('g-recaptcha-response', captchaToken)


  fetch('https://www.botonprint.com/scripts/form-u2756.php', {
    method: 'POST',
    body: data,
  }).then(res => res.json())
    .then(data => {
      console.log(data)
      window.location.href = '/?message-sent=1'
    })
})
