/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports) {

module.exports = M;

/***/ }),

/***/ 7:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(8);


/***/ }),

/***/ 8:
/***/ (function(module, exports, __webpack_require__) {

// Code specific to the home view

var M = __webpack_require__(0);

// About parallax
var parallaxElems = document.querySelectorAll('.parallax');
M.Parallax.init(parallaxElems);

// Card expansion
var outerCards = document.querySelectorAll('.card-outer');
var scrim = document.getElementById('scrim');
var _iteratorNormalCompletion = true;
var _didIteratorError = false;
var _iteratorError = undefined;

try {
  for (var _iterator = outerCards[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
    $elem = _step.value;

    $elem.addEventListener('click', function (event) {
      var _this = this;

      var inner = this.querySelector('.subcategory-container');
      if (!inner) return;
      inner.style.display = 'flex';

      event.preventDefault();

      // Convert to position fixed before animation
      var xCoord = this.offsetLeft - window.pageXOffset;
      var yCoord = this.offsetTop - window.pageYOffset;
      var width = this.clientWidth;
      var height = this.clientHeight;
      this.style.position = 'fixed';
      this.style.left = xCoord + 'px';
      this.style.top = yCoord + 'px';
      this.style.width = width + 'px';
      this.style.height = height + 'px';

      var img = this.querySelector('.card-image img');
      if (img) {
        img.parentElement.style.height = img.height;
      }

      setTimeout(function () {
        _this.classList.remove('hoverable');
        _this.classList.add('z-depth-5');
        _this.classList.add('expanded');
        _this.style.zIndex = 200;
        //
        scrim.classList.add('show');
      }, 0);
    });
  }
} catch (err) {
  _didIteratorError = true;
  _iteratorError = err;
} finally {
  try {
    if (!_iteratorNormalCompletion && _iterator.return) {
      _iterator.return();
    }
  } finally {
    if (_didIteratorError) {
      throw _iteratorError;
    }
  }
}

scrim.addEventListener('click', function () {
  scrim.classList.remove('show');
  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = outerCards[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      $elem = _step2.value;

      $elem.classList.add('hoverable');
      $elem.classList.remove('z-depth-5');
      $elem.classList.remove('expanded');

      $elem.removeAttribute('style');

      setTimeout(function () {
        var img = $elem.querySelector('.card-image img');
        if (img) {
          img.parentElement.style.height = img.height;
        }
      }, 200);

      var inner = $elem.querySelector('.subcategory-container');
      if (inner) inner.style.display = 'none';
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }
});

/***/ })

/******/ });