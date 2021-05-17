/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/ts/admin/classes/InputLetterCounter.ts":
/*!**********************************************************!*\
  !*** ./resources/ts/admin/classes/InputLetterCounter.ts ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var default_1 = function () {
  function default_1(fields) {
    this.fields = fields;
  }

  default_1.prototype.listenForEvents = function () {
    var _this = this;

    this.fields.forEach(function (field) {
      _this.displayCurrentLetterLeft(field);

      field.addEventListener('keyup', function () {
        return _this.displayCurrentLetterLeft(field);
      });
    });
  };

  default_1.prototype.displayCurrentLetterLeft = function (field) {
    var lettersCount = field.value.length;
    var maxLength = field.maxLength;
    var target = field.parentElement.querySelector('.counter');
    target.innerHTML = "" + (maxLength - lettersCount);
  };

  return default_1;
}();

exports.default = default_1;

/***/ }),

/***/ "./resources/ts/admin/classes/PostImageLoader.ts":
/*!*******************************************************!*\
  !*** ./resources/ts/admin/classes/PostImageLoader.ts ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var default_1 = function () {
  function default_1(imgElement, imgInput) {
    this.imgElement = imgElement;
    this.imgInput = imgInput;
  }

  default_1.prototype.listenForEvents = function () {
    var fileReader = new FileReader();
    var src = this.imgInput;
    var target = this.imgElement;
    this.imgInput.addEventListener('change', function () {
      if (src.files && src.files.length !== 0) {
        fileReader.readAsDataURL(src.files[0]);

        fileReader.onload = function () {
          target.src = this.result;
        };
      } else {
        target.src = '/storage/posts/placeholder.jpg';
      }
    });
  };

  return default_1;
}();

exports.default = default_1;

/***/ }),

/***/ "./resources/ts/admin/classes/TagsInput.ts":
/*!*************************************************!*\
  !*** ./resources/ts/admin/classes/TagsInput.ts ***!
  \*************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var default_1 = function () {
  function default_1(tagsField, target, popup, oldTagsField) {
    this.tagsField = tagsField;
    this.target = target;
    this.popup = popup;
    this.oldTagsField = oldTagsField;
    this.tags = [];
    this.chosenTags = [];
  }

  default_1.prototype.listenForEvent = function () {
    var _this = this;

    this.tagsField.addEventListener('keyup', function () {
      return _this.handleEvent(_this.tagsField.value);
    });
    this.listenForEnterEventToChooseFirstItemInPopup();
    this.checkIfThereAreOldTags();
  };

  default_1.prototype.openPopup = function (open) {
    if (open === void 0) {
      open = true;
    }

    open ? this.popup.classList.remove('is-hidden') : this.popup.classList.add('is-hidden');
  };

  default_1.prototype.handleEvent = function (value) {
    var _this = this;

    if (value === '') {
      this.openPopup(false);
      return;
    }

    fetch("/api/tags/search/" + value, {
      method: 'POST'
    }).then(function (res) {
      return res.json();
    }).then(function (res) {
      _this.tags = res;

      _this.printPopupItems();

      _this.addEventsPopupItems();
    })["catch"](function (err) {
      return console.error(err);
    });
  };

  default_1.prototype.printPopupItems = function () {
    this.openPopup();
    var popupHtml = '';
    this.tags.forEach(function (tag) {
      return popupHtml += "<li class=\"_popup-item\">" + tag.name + "</li>";
    });
    this.popup.innerHTML = popupHtml;
  };

  default_1.prototype.getHtmlForTag = function (tag) {
    return "\n            <span class=\"tag is-normal is-dark mr-1\" style=\"background-color: " + tag.color + "\">\n                " + tag.name + "\n                <button type=\"button\" class=\"delete is-small\" id=\"delete-tag-" + tag.id + "\"></button>\n                <input type=\"hidden\" name=\"tags[]\" value=\"" + tag.id + "\">\n            </span>\n        ";
  };

  default_1.prototype.addEventsPopupItems = function () {
    var _this = this;

    var popupItems = document.querySelectorAll('._popup-item');
    popupItems.forEach(function (item) {
      item.addEventListener('click', function () {
        return _this.handlePopupItemClickEvent(item.innerHTML.trim());
      });
    });
  };

  default_1.prototype.handlePopupItemClickEvent = function (tagName) {
    this.tagsField.value = '';
    this.openPopup(false);
    this.addTagToHtml(tagName);
  };

  default_1.prototype.addTagToHtml = function (tagOrName) {
    var tag = typeof tagOrName === 'string' ? this.tags.filter(function (tag) {
      return tag.name === tagOrName;
    })[0] : tagOrName;
    var duplicates = this.chosenTags.filter(function (chosenTag) {
      return chosenTag.id === tag.id;
    });
    if (duplicates.length > 0) return;
    this.chosenTags.push(tag);
    this.target.insertAdjacentHTML('beforeend', this.getHtmlForTag(tag));
    this.addRemoveTagEvent(tag.id);
  };

  default_1.prototype.listenForEnterEventToChooseFirstItemInPopup = function () {
    var _this = this;

    this.tagsField.addEventListener('keypress', function (e) {
      if (e.code === 'Enter') {
        var tag = _this.tags[0] || null;

        if (tag) {
          _this.openPopup(false);

          _this.tagsField.value = '';

          _this.addTagToHtml(tag);
        }

        e.preventDefault();
      }
    });
  };

  default_1.prototype.checkIfThereAreOldTags = function () {
    var _this = this;

    var oldTags = JSON.parse(this.oldTagsField.value);
    this.tags = oldTags;
    oldTags.forEach(function (oldTag) {
      return _this.addTagToHtml(oldTag);
    });
  };

  default_1.prototype.addRemoveTagEvent = function (id) {
    var _this = this;

    var deleteTagButton = document.getElementById("delete-tag-" + id);
    deleteTagButton.addEventListener('click', function () {
      deleteTagButton.parentElement.remove();
      _this.chosenTags = _this.chosenTags.filter(function (chosenTag) {
        return chosenTag.id !== id;
      });
    });
  };

  return default_1;
}();

exports.default = default_1;

/***/ }),

/***/ "./resources/ts/admin/components/editBlog.ts":
/*!***************************************************!*\
  !*** ./resources/ts/admin/components/editBlog.ts ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {



var __importDefault = this && this.__importDefault || function (mod) {
  return mod && mod.__esModule ? mod : {
    "default": mod
  };
};

Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var TagsInput_1 = __importDefault(__webpack_require__(/*! ../classes/TagsInput */ "./resources/ts/admin/classes/TagsInput.ts"));

var InputLetterCounter_1 = __importDefault(__webpack_require__(/*! ../classes/InputLetterCounter */ "./resources/ts/admin/classes/InputLetterCounter.ts"));

var PostImageLoader_1 = __importDefault(__webpack_require__(/*! ../classes/PostImageLoader */ "./resources/ts/admin/classes/PostImageLoader.ts"));

(function ExecuteTagsInputScript() {
  var tagsField = document.getElementById('post-tags');
  var target = document.getElementById('suggestions-target');
  var popup = document.getElementById('post-tags-popup');
  var oldTagsField = document.getElementById('old-post-tags');
  if (!tagsField || !target || !popup || !oldTagsField) return;
  new TagsInput_1["default"](tagsField, target, popup, oldTagsField).listenForEvent();
})();

(function ExecuteLetterCounter() {
  var fields = document.querySelectorAll('.letter-counter');
  if (!fields) return;
  new InputLetterCounter_1["default"](Array.from(fields)).listenForEvents();
})();

(function ExecutePostImageLoader() {
  var imgElement = document.getElementById('post-image');
  var imgInput = document.getElementById('post-image-input');
  if (!imgElement || !imgInput) return;
  new PostImageLoader_1["default"](imgElement, imgInput).listenForEvents();
})();

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
var exports = __webpack_exports__;
/*!***********************************!*\
  !*** ./resources/ts/admin/app.ts ***!
  \***********************************/


Object.defineProperty(exports, "__esModule", ({
  value: true
}));

__webpack_require__(/*! ./components/editBlog */ "./resources/ts/admin/components/editBlog.ts");
})();

/******/ })()
;