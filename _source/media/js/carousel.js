var ResponsiveSliderAds;

ResponsiveSliderAds = (function() {
  ResponsiveSliderAds.prototype.element = 'defaultValue';

  ResponsiveSliderAds.prototype.radios = 'defaultValue';

  ResponsiveSliderAds.prototype.currentIndex = 0;

  ResponsiveSliderAds.prototype.nIntervalId = 'defaultValue';

  ResponsiveSliderAds.prototype.nextButton = null;

  ResponsiveSliderAds.prototype.previousButton = null;

  ResponsiveSliderAds.prototype.interval = 5000;

  function ResponsiveSliderAds(params) {
    var _this, key, value;
    _this = this;
    for (key in params) {
      value = params[key];
      if (_this[key]) {
         console.log("ResponsiveSliderAds: constructor() { define '" + key + "' as '" + value + "' }");
      } else {
         console.log("ResponsiveSliderAds: constructor() { param '" + key + "' doesn't exist }");
      }
      _this[key] = value;
    }
    if (_this.nextButton) {
      _this.nextButton.addEventListener("click", (function(_this) {
        return function(event) {
          return _this.clickHandler('next');
        };
      })(this));
    }
    if (_this.previousButton) {
      _this.previousButton.addEventListener("click", (function(_this) {
        return function(event) {
          return _this.clickHandler('previous');
        };
      })(this));
    }
    _this.element.addEventListener("mouseenter", (function(_this) {
      return function(event) {
        return _this.action('stop');
      };
    })(this));
    _this.element.addEventListener("mouseleave", (function(_this) {
      return function(event) {
        return _this.action('start');
      };
    })(this));
  }

  ResponsiveSliderAds.prototype.action = function(action) {
    var _this;
    _this = this;
    switch (action) {
      case "start":
         console.log("ResponsiveSliderAds: action() { action is '" + action + "' }");
        _this.nIntervalId = window.setInterval(function() {
          return _this.gotoItem();
        }, _this.interval);
        break;
      default:
         console.log("ResponsiveSliderAds: action() { action is '" + action + "' }");
        return clearInterval(_this.nIntervalId);
    }
  };

  ResponsiveSliderAds.prototype.gotoItem = function(index, direction) {
    var _this;
    _this = this;
    if (!direction) {
       console.log("ResponsiveSliderAds: gotoItem() { direction is 'undefined', default to 'next'}");
      direction = 'next';
    }
    if (index !== 0) {
      if (!index) {
         console.log("ResponsiveSliderAds: gotoItem() { index is 'undefined', getting direction: '" + direction + "' item }");
        index = _this.getNextIndex(direction);
      }
    }
    if (index === -1 || index === _this.radios.length + 1) {
       console.log("ResponsiveSliderAds: gotoItem() { index '" + index + "' doesn't exist, default to 0 }");
      index = 0;
    }
     console.log("ResponsiveSliderAds: gotoItem() { set 'radio[" + index + "]' to checked }");
    return _this.radios[index].checked = true;
  };

  ResponsiveSliderAds.prototype.getNextIndex = function(direction) {
    var _this, nextIndexNumber;
    _this = this;
    switch (direction) {
      case 'previous':
        nextIndexNumber = _this.currentIndex - 1;
        if (nextIndexNumber === -1) {
           console.log("ResponsiveSliderAds: getNextIndex() { first slide reached, goto last slide }");
          nextIndexNumber = _this.radios.length - 1;
        }
        break;
      default:
        nextIndexNumber = _this.currentIndex + 1;
        if (nextIndexNumber === _this.radios.length) {
           console.log("ResponsiveSliderAds: getNextIndex() { last slide reached, goto first slide }");
          nextIndexNumber = 0;
        }
    }
    _this.currentIndex = nextIndexNumber;
    return nextIndexNumber;
  };

  ResponsiveSliderAds.prototype.clickHandler = function(direction) {
    var _this;
    _this = this;
    if (!direction) {
       console.log("ResponsiveSliderAds: gotoItem() { direction is 'undefined', default to 'next'}");
      direction = 'next';
    }
    _this.action('stop');
    return _this.gotoItem(_this.getNextIndex(direction), direction);
  };

  return ResponsiveSliderAds;

})();
