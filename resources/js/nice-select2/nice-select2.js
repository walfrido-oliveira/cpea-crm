//import "../scss/nice-select2.scss";

// utility functions
function triggerClick(el) {
    el.dispatchEvent(new Event('click'));
}

function triggerChange(el) {
    var event = document.createEvent("HTMLEvents");
    event.initEvent("change", true, false);

    el.dispatchEvent(event);
  }

function attr(el, key) {
  return el.getAttribute(key);
}

function data(el, key) {
  return el.getAttribute("data-" + key);
}

function hasClass(el, className) {
  if (el) return el.classList.contains(className);
  else return false;
}

function addClass(el, className) {
  if (el) return el.classList.add(className);
}

function removeClass(el, className) {
  if (el) return el.classList.remove(className);
}

var defaultOptions = {
  data: null,
  searchable: false,
  reverse: false
};
function NiceSelect(element, options) {
  this.el = element;
  this.config = Object.assign({}, defaultOptions, options || {});

  this.data = this.config.data;
  this.selectedOptions = [];

  this.placeholder =
    attr(this.el, "placeholder") ||
    this.config.placeholder ||
    "";

  this.dropdown = null;
  this.multiple = attr(this.el, "multiple");
  this.disabled = attr(this.el, "disabled");

  this.create();
}

NiceSelect.prototype.create = function() {
  this.el.style.display = "none";

  this.extractData();
  this.renderDropdown();
  this.bindEvent();
};

NiceSelect.prototype.processData = function(data) {
  var options = [];
   data.forEach(function(item) {
    options.push({
      data: item,
      attributes: {
        selected: false,
        disabled: false
      }
    });
  });
  this.options = options;
};

NiceSelect.prototype.extractData = function() {
  var options = this.el.querySelectorAll("option");
  var data = [];
  var allOptions = [];
  var selectedOptions = [];

  options.forEach(item => {
    var itemData = {
      text: item.innerText,
      value: item.value
    };

    var attributes = {
        selected: item.selected  || item.value == this.el.value,
        disabled: item.getAttribute("disabled") != null
    };

    data.push(itemData);
    allOptions.push({ data: itemData, attributes: attributes });
  });

  this.data = data;
  this.options = allOptions;
  this.options.forEach(function(item) {
    if (item.attributes.selected) selectedOptions.push(item);
  });

  this.selectedOptions = selectedOptions;
};

NiceSelect.prototype.renderDropdown = function() {
  var classes = [
    "nice-select",
    attr(this.el, "class") || "",
    this.disabled ? "disabled" : "",
    this.multiple ? "has-multiple" : ""
  ];

  let searchHtml = `<div class="nice-select-search-box">
<input type="text" class="nice-select-search" placeholder="Buscar..."/>
</div>`;

  var html = `<div class="${classes.join(" ")}" tabindex="${
    this.disabled ? null : 0
  }">
  <span class="${this.multiple ? "multiple-options" : "current"}">

  </span>
  <div class="nice-select-dropdown ${this.config.reverse ? 'reverse' : ''}">
  ${this.config.searchable ? searchHtml : ""}
  <ul class="list"></ul>
  </div></div>
`;

  this.el.insertAdjacentHTML("afterend", html);

  this.dropdown = this.el.nextElementSibling;
  this._renderSelectedItems();
  this._renderItems();
};

NiceSelect.prototype._renderSelectedItems = function() {
  if (this.multiple) {
    var selectedHtml = "";

    this.selectedOptions.forEach(function(item) {
        selectedHtml += `<span class="current" data-value="${item.data.value}">`;
        if(item.data.text != '')
        {
            selectedHtml += `<button data-value="${item.data.value}" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-700 hover:text-gray-800 hover:bg-gray-100 focus:outline-none">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>`;
        }
        selectedHtml += `${item.data.text}`;
        selectedHtml += `</span>`;
    });
    selectedHtml = selectedHtml == "" ? this.placeholder : selectedHtml;

    this.dropdown.querySelector(".multiple-options").innerHTML = selectedHtml;
  } else {
    var html =
      this.selectedOptions.length > 0
        ? this.selectedOptions[0].data.text
        : this.placeholder;

    this.dropdown.querySelector(".current").innerHTML = html;
  }
};

NiceSelect.prototype._renderItems = function() {
  var ul = this.dropdown.querySelector("ul");
  this.options.forEach(item => {
    ul.appendChild(this._renderItem(item));
  });
};

NiceSelect.prototype._renderItem = function(option) {
  var el = document.createElement("li");
  el.setAttribute("data-value", option.data.value);

  var classList = [
    "option",
    (option.attributes.selected ) ? "selected" : null,
    option.attributes.disabled ? "disabled" : null
  ];

  el.classList.add(...classList);
  el.innerHTML = option.data.text;
  el.addEventListener("click", this._onItemClicked.bind(this, option));
  option.element = el;
  return el;
};

NiceSelect.prototype.update = function() {
  this.extractData();
  if (this.dropdown) {
    var open = hasClass(this.dropdown, "open");
    this.dropdown.parentNode.removeChild(this.dropdown);
    this.create();

    if (open) {
      triggerClick(this.dropdown);
    }
  }
};

NiceSelect.prototype.disable = function() {
  if (!this.disabled) {
    this.disabled = true;
    addClass(this.dropdown, "disabled");
  }
};

NiceSelect.prototype.enable = function() {
  if (this.disabled) {
    this.disabled = false;
    removeClass(this.dropdown, "disabled");
  }
};

NiceSelect.prototype.clear = function() {
  this.selectedOptions = [];
  this._renderSelectedItems();
  this.updateSelectValue();
  triggerChange(this.el);
};

NiceSelect.prototype.destroy = function() {
  if (this.dropdown) {
    this.dropdown.parentNode.removeChild(this.dropdown);
    this.el.style.display = "";
  }
};

NiceSelect.prototype.bindEvent = function() {
  var $this = this;
  this.dropdown.addEventListener("click", this._onClicked.bind(this));

  this.dropdown.querySelectorAll(".multiple-options .current button").forEach(item => {
    item.addEventListener("click", $this._onRemoveItem.bind({
        el: $this,
        button: item
    }));
  });

  this.dropdown.addEventListener("keydown", this._onKeyPressed.bind(this));
  document.addEventListener("click", this._onClickedOutside.bind(this));

  //this.el.addEventListener("change", this._change.bind(this));

  if (this.config.searchable) {
    this._bindSearchEvent();
  }
};

NiceSelect.prototype._bindSearchEvent = function() {
  var searchBox = this.dropdown.querySelector(".nice-select-search");
  if (searchBox)
    searchBox.addEventListener("click", function(e) {
      e.stopPropagation();
      return false;
    });

  searchBox.addEventListener("input", this._onSearchChanged.bind(this));
};

NiceSelect.prototype._onRemoveItem = function(e) {
    e.preventDefault();
    e.stopPropagation();

    let optionEl = this.el.dropdown.querySelector(`.list li[data-value="${this.button.dataset.value}"]`);

    removeClass(optionEl, "selected");
    let temp = [];
    this.el.selectedOptions.forEach(item => {
        if(item.data.value != optionEl.dataset.value) temp.push(item);
    });

    this.el.selectedOptions = temp;

    this.el._renderSelectedItems();
    this.el.updateSelectValue();

    this.el.dropdown.querySelectorAll(".multiple-options .current button").forEach(item => {
        item.addEventListener("click", this.el._onRemoveItem.bind({
            el: this.el,
            button: item
        }));
    });
}

NiceSelect.prototype._onClicked = function(e) {
  this.dropdown.classList.toggle("open");

  if (this.dropdown.classList.contains("open")) {
    var search = this.dropdown.querySelector(".nice-select-search");
    if (search) {
      search.value = "";
      search.focus();
    }

    var t = this.dropdown.querySelector(".focus");
    removeClass(t, "focus");
    t = this.dropdown.querySelector(".selected");
    addClass(t, "focus");
    this.dropdown.querySelectorAll("ul li").forEach(function(item) {
      item.style.display = "";
    });
  } else {
    this.dropdown.focus();
  }

  /*var container = this.dropdown.querySelector('.nice-select-dropdown');
  var bottomContainer = container.getBoundingClientRect().bottom;
  var bottomBody = document.querySelector("body").getBoundingClientRect().bottom;
  console.log(bottomBody);
  console.log(bottomContainer);
  if (bottomContainer > bottomBody) {
      container.classList.add('reverse');
  } else {
      container.classList.remove('reverse');
  }*/
};

NiceSelect.prototype._onItemClicked = function(option, e) {
  var optionEl = e.target;

  if (!hasClass(optionEl, "disabled")) {
    if (this.multiple) {
      if (!hasClass(optionEl, "selected")) {
        addClass(optionEl, "selected");
        this.selectedOptions.push(option);
      }else {
        removeClass(optionEl, "selected");
        let temp = [];
        this.selectedOptions.forEach(item => {
            if(item.data.value != option.data.value) temp.push(item);
        });

        this.selectedOptions = temp;
      }

    } else {
      this.selectedOptions.forEach(function(item) {
        removeClass(item.element, "selected");
      });

      addClass(optionEl, "selected");
      this.selectedOptions = [option];
    }

    this._renderSelectedItems();
    this.updateSelectValue();

    this.dropdown.querySelectorAll(".multiple-options .current button").forEach(item => {
        item.addEventListener("click", this._onRemoveItem.bind({
            el: this,
            button: item
        }));
    });
  }
};

NiceSelect.prototype.updateSelectValue = function() {
  if (this.multiple) {
    var elValue = this.el;

    elValue.querySelectorAll('option').forEach(item => {
        item.selected = false;
    });

    elValue.querySelectorAll('option').forEach(item2 => {
        this.selectedOptions.forEach(function(item) {
            if(item.data.value == item2.value) item2.selected = true;
        });
    });

  } else if (this.selectedOptions.length > 0) {
    this.el.value = this.selectedOptions[0].data.value;
  }

  triggerChange(this.el);
};

NiceSelect.prototype._onClickedOutside = function(e) {
  if (!this.dropdown.contains(e.target)) {
    this.dropdown.classList.remove("open");
  }
};

NiceSelect.prototype._onKeyPressed = function(e) {
  // Keyboard events

  var focusedOption = this.dropdown.querySelector(".focus");

  var open = this.dropdown.classList.contains("open");

  // Space or Enter
  if (e.keyCode == 13) {
    if (open) {
      e.preventDefault();
      triggerClick(focusedOption);
    } else {
      triggerClick(this.dropdown);
    }
  } else if (e.keyCode == 40) {
    // Down
    if (!open) {
      triggerClick(this.dropdown);
    } else {
      var next = this._findNext(focusedOption);
      if (next) {
        var t = this.dropdown.querySelector(".focus");
        removeClass(t, "focus");
        addClass(next, "focus");
      }
    }
    e.preventDefault();
  } else if (e.keyCode == 38) {
    // Up
    if (!open) {
      triggerClick(this.dropdown);
    } else {
      var prev = this._findPrev(focusedOption);
      if (prev) {
        var t = this.dropdown.querySelector(".focus");
        removeClass(t, "focus");
        addClass(prev, "focus");
      }
    }
    e.preventDefault();
  } else if (e.keyCode == 27 && open) {
    // Esc
    triggerClick(this.dropdown);
  }
  return false;
};

NiceSelect.prototype._findNext = function(el) {
  if (el) {
    el = el.nextElementSibling;
  } else {
    el = this.dropdown.querySelector(".list .option");
  }

  while (el) {
    if (!hasClass(el, "disabled") && el.style.display != "none") {
      return el;
    }
    el = el.nextElementSibling;
  }

  return null;
};

NiceSelect.prototype._findPrev = function(el) {
  if (el) {
    el = el.previousElementSibling;
  } else {
    el = this.dropdown.querySelector(".list .option:last-child");
  }

  while (el) {
    if (!hasClass(el, "disabled") && el.style.display != "none") {
      return el;
    }
    el = el.previousElementSibling;
  }

  return null;
};

NiceSelect.prototype._onSearchChanged = function(e) {
  var open = this.dropdown.classList.contains("open");
  var text = e.target.value;
  text = text.toLowerCase();

  if (text == "") {
    this.options.forEach(function(item) {
      item.element.style.display = "";
    });
  } else if (open) {
    var matchReg = new RegExp(text);
    this.options.forEach(function(item) {
      var optionText = item.data.text.toLowerCase();
      var matched = matchReg.test(optionText);
      item.element.style.display = matched ? "" : "none";
    });
  }

  this.dropdown.querySelectorAll(".focus").forEach(function(item) {
    removeClass(item, "focus");
  });

  var firstEl = this._findNext(null);
  addClass(firstEl, "focus");
};

export function bind(el, options) {
  return new NiceSelect(el, options);
}

NiceSelect.prototype._change = function() {
    this.extractData();
    if (this.dropdown) {
        var open = hasClass(this.dropdown, "open");
        if(this.dropdown.parentNode) this.dropdown.parentNode.removeChild(this.dropdown);
        this.create();

        if (open) {
        triggerClick(this.dropdown);
        }
    }
    console.log(3);
};

window.addEventListener("load", function() {
    document.querySelectorAll('.nice-select-dropdown').forEach(container => {
        var bottomContainer = container.getBoundingClientRect().bottom;
        var bottomBody = document.querySelector("body").getBoundingClientRect().bottom;

        if (bottomContainer > bottomBody) {
            container.classList.add('reverse');
        } else {
            container.classList.remove('reverse');
        }
    });
});
