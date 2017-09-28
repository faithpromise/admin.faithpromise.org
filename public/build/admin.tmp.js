(function(context, factory) {
  'use strict';

  var moment,
      angular,
      Pikaday;
  if (typeof exports === 'object') {
    // CommonJS module
    // Load moment.js as an optional dependency
    try { moment = require('moment'); } catch (e) {}
    // angular and Pikaday actually required
    angular = require('angular');
    Pikaday = require('pikaday');
    module.exports = factory.call(context, angular, moment, Pikaday);
  } else if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(function (req)
    {
      try { moment = req('moment'); } catch (e) {}
      angular = require('angular');
      Pikaday = require('pikaday');
      return factory.call(context, angular, moment, Pikaday);
    });
  } else {
    // Everything attached to root window context
    context.Pikaday = factory.call(context, context.angular, context.moment, context.Pikaday);
  }
}(this, function (angular, moment, Pikaday) {
  'use strict';

  angular.module('angular-pikaday', [])
  .constant('pikaconfig', {
    // Simple observer pattern to allow outsiders to change Pikaday options
    pikadayObservers: [],
    updatePikadayOptions: function() {
      angular.forEach(this.pikadayObservers, function(callback) {
        callback();
      });
    },

    option_overrides: {}
  })
  .directive('pikaday', ['pikaconfig', function(pikaconfig) {
    var timeTokens = ['H', 'HH', 'h', 'hh', 'a', 'A', 's', 'ss', 'S', 'SS', 'SSS', 'Z', 'ZZ', 'LLL', 'LLLL', 'lll', 'llll'];

    return {
      require: '?ngModel',
      restrict: 'A', // A = Attribute

      link: function(scope, inputElement, attrs, ngModel) {
        // Setup Pikaday
        var options = {
          field: inputElement[0],
          showTime: !!attrs.pikaday.match(timeTokens.join('|'))
        };

        if (ngModel) {
          options.onSelect = function( selectedDate ) {
            scope.$apply(function() {
              ngModel.$setViewValue(selectedDate);
            });
          };
        }

        // Attach picker to element
        inputElement[0]._pikaday = new Pikaday( options );
        var picker = inputElement[0]._pikaday;

        // We need to update our options
        // Using observer pattern so as not to pollute scope or add a bunch of watches
        var optionUpdateCallback = function() {
          angular.extend(picker._o, pikaconfig.option_overrides);
          inputElement.val(picker.toString());
        };
        pikaconfig.pikadayObservers.push(optionUpdateCallback);

        // Clean up Pikaday when this directive instance is destroyed
        scope.$on('$destroy', function() {
          picker.destroy();
          // Remove self from observables
          pikaconfig.pikadayObservers.splice(
              pikaconfig.pikadayObservers.indexOf(optionUpdateCallback), 1
            );
        });

        // Allow date format to be set and dynamically changed
        attrs.$observe('pikaday', function(format) {
          if (format) {
            picker._o.format = format;
            if(!pikaconfig.option_overrides.inputFormats) {
              picker._o.inputFormats = picker._o.format;
            }
            inputElement.val(picker.toString());

            picker._o.showTime = !!format.match(timeTokens.join('|'));

            if (ngModel) {
              ngModel.$validate();
            }
          }
        });

        if (ngModel) {
          // Incoming from model changes, revalidate and force a date type
          ngModel.$formatters.push(function(value) {
            if (angular.isDate(value)) {
              picker.setDate(value, true);
              return picker.toString();
            }
            return '';
          });
          // Outgoing... usually from $setViewValue, again ensuring a date
          ngModel.$parsers.push(function(value) {
            if (ngModel.$isEmpty(value)) {
               ngModel.$setValidity('pikaday', true);
               return null;
            }

            var m;
            if (typeof moment === 'function') {
                if(picker._o.inputFormats && !(value instanceof Date)) {
                    m = moment(value, picker._o.inputFormats);
                } else {
                    m = moment(value);
                }
            }

            if (m && m.isValid()) {
              ngModel.$setValidity('pikaday', true);
              return m.toDate();
            }

            ngModel.$setValidity('pikaday', false);
            return undefined;
          });
        }

        // Call all update options when spinning up pikaday instance
        pikaconfig.updatePikadayOptions();
      }
    };
  }]);
}));

;(function() {


// Create all modules and define dependencies to make sure they exist
// and are loaded in the correct order to satisfy dependency injection
// before all nested files are concatenated by Grunt

// Modules
angular.module('angular-jwt',
    [
        'angular-jwt.interceptor',
        'angular-jwt.jwt'
    ]);

 angular.module('angular-jwt.interceptor', [])
  .provider('jwtInterceptor', function() {

    this.urlParam = null;
    this.authHeader = 'Authorization';
    this.authPrefix = 'Bearer ';
    this.tokenGetter = function() {
      return null;
    }

    var config = this;

    this.$get = ["$q", "$injector", "$rootScope", function ($q, $injector, $rootScope) {
      return {
        request: function (request) {
          if (request.skipAuthorization) {
            return request;
          }

          if (config.urlParam) {
            request.params = request.params || {};
            // Already has the token in the url itself
            if (request.params[config.urlParam]) {
              return request;
            }
          } else {
            request.headers = request.headers || {};
            // Already has an Authorization header
            if (request.headers[config.authHeader]) {
              return request;
            }
          }

          var tokenPromise = $q.when($injector.invoke(config.tokenGetter, this, {
            config: request
          }));

          return tokenPromise.then(function(token) {
            if (token) {
              if (config.urlParam) {
                request.params[config.urlParam] = token;
              } else {
                request.headers[config.authHeader] = config.authPrefix + token;
              }
            }
            return request;
          });
        },
        responseError: function (response) {
          // handle the case where the user is not authenticated
          if (response.status === 401) {
            $rootScope.$broadcast('unauthenticated', response);
          }
          return $q.reject(response);
        }
      };
    }];
  });

 angular.module('angular-jwt.jwt', [])
  .service('jwtHelper', function() {

    this.urlBase64Decode = function(str) {
      var output = str.replace(/-/g, '+').replace(/_/g, '/');
      switch (output.length % 4) {
        case 0: { break; }
        case 2: { output += '=='; break; }
        case 3: { output += '='; break; }
        default: {
          throw 'Illegal base64url string!';
        }
      }
      return decodeURIComponent(escape(window.atob(output))); //polifyll https://github.com/davidchambers/Base64.js
    }


    this.decodeToken = function(token) {
      var parts = token.split('.');

      if (parts.length !== 3) {
        throw new Error('JWT must have 3 parts');
      }

      var decoded = this.urlBase64Decode(parts[1]);
      if (!decoded) {
        throw new Error('Cannot decode the token');
      }

      return JSON.parse(decoded);
    }

    this.getTokenExpirationDate = function(token) {
      var decoded;
      decoded = this.decodeToken(token);

      if(typeof decoded.exp === "undefined") {
        return null;
      }

      var d = new Date(0); // The 0 here is the key, which sets the date to the epoch
      d.setUTCSeconds(decoded.exp);

      return d;
    };

    this.isTokenExpired = function(token, offsetSeconds) {
      var d = this.getTokenExpirationDate(token);
      offsetSeconds = offsetSeconds || 0;
      if (d === null) {
        return false;
      }

      // Token expired?
      return !(d.valueOf() > (new Date().valueOf() + (offsetSeconds * 1000)));
    };
  });

}());
;angular.module('ui.bootstrap.position', [])

/**
 * A set of utility methods that can be use to retrieve position of DOM elements.
 * It is meant to be used where we need to absolute-position DOM elements in
 * relation to other, existing elements (this is the case for tooltips, popovers,
 * typeahead suggestions etc.).
 */
  .factory('$uibPosition', ['$document', '$window', function($document, $window) {
    function getStyle(el, cssprop) {
      if (el.currentStyle) { //IE
        return el.currentStyle[cssprop];
      } else if ($window.getComputedStyle) {
        return $window.getComputedStyle(el)[cssprop];
      }
      // finally try and get inline style
      return el.style[cssprop];
    }

    /**
     * Checks if a given element is statically positioned
     * @param element - raw DOM element
     */
    function isStaticPositioned(element) {
      return (getStyle(element, 'position') || 'static' ) === 'static';
    }

    /**
     * returns the closest, non-statically positioned parentOffset of a given element
     * @param element
     */
    var parentOffsetEl = function(element) {
      var docDomEl = $document[0];
      var offsetParent = element.offsetParent || docDomEl;
      while (offsetParent && offsetParent !== docDomEl && isStaticPositioned(offsetParent) ) {
        offsetParent = offsetParent.offsetParent;
      }
      return offsetParent || docDomEl;
    };

    return {
      /**
       * Provides read-only equivalent of jQuery's position function:
       * http://api.jquery.com/position/
       */
      position: function(element) {
        var elBCR = this.offset(element);
        var offsetParentBCR = { top: 0, left: 0 };
        var offsetParentEl = parentOffsetEl(element[0]);
        if (offsetParentEl != $document[0]) {
          offsetParentBCR = this.offset(angular.element(offsetParentEl));
          offsetParentBCR.top += offsetParentEl.clientTop - offsetParentEl.scrollTop;
          offsetParentBCR.left += offsetParentEl.clientLeft - offsetParentEl.scrollLeft;
        }

        var boundingClientRect = element[0].getBoundingClientRect();
        return {
          width: boundingClientRect.width || element.prop('offsetWidth'),
          height: boundingClientRect.height || element.prop('offsetHeight'),
          top: elBCR.top - offsetParentBCR.top,
          left: elBCR.left - offsetParentBCR.left
        };
      },

      /**
       * Provides read-only equivalent of jQuery's offset function:
       * http://api.jquery.com/offset/
       */
      offset: function(element) {
        var boundingClientRect = element[0].getBoundingClientRect();
        return {
          width: boundingClientRect.width || element.prop('offsetWidth'),
          height: boundingClientRect.height || element.prop('offsetHeight'),
          top: boundingClientRect.top + ($window.pageYOffset || $document[0].documentElement.scrollTop),
          left: boundingClientRect.left + ($window.pageXOffset || $document[0].documentElement.scrollLeft)
        };
      },

      /**
       * Provides coordinates for the targetEl in relation to hostEl
       */
      positionElements: function(hostEl, targetEl, positionStr, appendToBody) {
        var positionStrParts = positionStr.split('-');
        var pos0 = positionStrParts[0], pos1 = positionStrParts[1] || 'center';

        var hostElPos,
          targetElWidth,
          targetElHeight,
          targetElPos;

        hostElPos = appendToBody ? this.offset(hostEl) : this.position(hostEl);

        targetElWidth = targetEl.prop('offsetWidth');
        targetElHeight = targetEl.prop('offsetHeight');

        var shiftWidth = {
          center: function() {
            return hostElPos.left + hostElPos.width / 2 - targetElWidth / 2;
          },
          left: function() {
            return hostElPos.left;
          },
          right: function() {
            return hostElPos.left + hostElPos.width;
          }
        };

        var shiftHeight = {
          center: function() {
            return hostElPos.top + hostElPos.height / 2 - targetElHeight / 2;
          },
          top: function() {
            return hostElPos.top;
          },
          bottom: function() {
            return hostElPos.top + hostElPos.height;
          }
        };

        switch (pos0) {
          case 'right':
            targetElPos = {
              top: shiftHeight[pos1](),
              left: shiftWidth[pos0]()
            };
            break;
          case 'left':
            targetElPos = {
              top: shiftHeight[pos1](),
              left: hostElPos.left - targetElWidth
            };
            break;
          case 'bottom':
            targetElPos = {
              top: shiftHeight[pos0](),
              left: shiftWidth[pos1]()
            };
            break;
          default:
            targetElPos = {
              top: hostElPos.top - targetElHeight,
              left: shiftWidth[pos1]()
            };
            break;
        }

        return targetElPos;
      }
    };
  }]);

/* Deprecated position below */

angular.module('ui.bootstrap.position')

.value('$positionSuppressWarning', false)

.service('$position', ['$log', '$positionSuppressWarning', '$uibPosition', function($log, $positionSuppressWarning, $uibPosition) {
  if (!$positionSuppressWarning) {
    $log.warn('$position is now deprecated. Use $uibPosition instead.');
  }

  angular.extend(this, $uibPosition);
}]);

;angular.module('ui.bootstrap.dropdown', ['ui.bootstrap.position'])

.constant('uibDropdownConfig', {
  openClass: 'open'
})

.service('uibDropdownService', ['$document', '$rootScope', function($document, $rootScope) {
  var openScope = null;

  this.open = function(dropdownScope) {
    if (!openScope) {
      $document.bind('click', closeDropdown);
      $document.bind('keydown', keybindFilter);
    }

    if (openScope && openScope !== dropdownScope) {
      openScope.isOpen = false;
    }

    openScope = dropdownScope;
  };

  this.close = function(dropdownScope) {
    if (openScope === dropdownScope) {
      openScope = null;
      $document.unbind('click', closeDropdown);
      $document.unbind('keydown', keybindFilter);
    }
  };

  var closeDropdown = function(evt) {
    // This method may still be called during the same mouse event that
    // unbound this event handler. So check openScope before proceeding.
    if (!openScope) { return; }

    if (evt && openScope.getAutoClose() === 'disabled')  { return ; }

    var toggleElement = openScope.getToggleElement();
    if (evt && toggleElement && toggleElement[0].contains(evt.target)) {
      return;
    }

    var dropdownElement = openScope.getDropdownElement();
    if (evt && openScope.getAutoClose() === 'outsideClick' &&
      dropdownElement && dropdownElement[0].contains(evt.target)) {
      return;
    }

    openScope.isOpen = false;

    if (!$rootScope.$$phase) {
      openScope.$apply();
    }
  };

  var keybindFilter = function(evt) {
    if (evt.which === 27) {
      openScope.focusToggleElement();
      closeDropdown();
    } else if (openScope.isKeynavEnabled() && /(38|40)/.test(evt.which) && openScope.isOpen) {
      evt.preventDefault();
      evt.stopPropagation();
      openScope.focusDropdownEntry(evt.which);
    }
  };
}])

.controller('UibDropdownController', ['$scope', '$element', '$attrs', '$parse', 'uibDropdownConfig', 'uibDropdownService', '$animate', '$uibPosition', '$document', '$compile', '$templateRequest', function($scope, $element, $attrs, $parse, dropdownConfig, uibDropdownService, $animate, $position, $document, $compile, $templateRequest) {
  var self = this,
    scope = $scope.$new(), // create a child scope so we are not polluting original one
    templateScope,
    openClass = dropdownConfig.openClass,
    getIsOpen,
    setIsOpen = angular.noop,
    toggleInvoker = $attrs.onToggle ? $parse($attrs.onToggle) : angular.noop,
    appendToBody = false,
    keynavEnabled =false,
    selectedOption = null;


  $element.addClass('dropdown');

  this.init = function() {
    if ($attrs.isOpen) {
      getIsOpen = $parse($attrs.isOpen);
      setIsOpen = getIsOpen.assign;

      $scope.$watch(getIsOpen, function(value) {
        scope.isOpen = !!value;
      });
    }

    appendToBody = angular.isDefined($attrs.dropdownAppendToBody);
    keynavEnabled = angular.isDefined($attrs.uibKeyboardNav);

    if (appendToBody && self.dropdownMenu) {
      $document.find('body').append(self.dropdownMenu);
      $element.on('$destroy', function handleDestroyEvent() {
        self.dropdownMenu.remove();
      });
    }
  };

  this.toggle = function(open) {
    return scope.isOpen = arguments.length ? !!open : !scope.isOpen;
  };

  // Allow other directives to watch status
  this.isOpen = function() {
    return scope.isOpen;
  };

  scope.getToggleElement = function() {
    return self.toggleElement;
  };

  scope.getAutoClose = function() {
    return $attrs.autoClose || 'always'; //or 'outsideClick' or 'disabled'
  };

  scope.getElement = function() {
    return $element;
  };

  scope.isKeynavEnabled = function() {
    return keynavEnabled;
  };

  scope.focusDropdownEntry = function(keyCode) {
    var elems = self.dropdownMenu ? //If append to body is used.
      (angular.element(self.dropdownMenu).find('a')) :
      (angular.element($element).find('ul').eq(0).find('a'));

    switch (keyCode) {
      case (40): {
        if (!angular.isNumber(self.selectedOption)) {
          self.selectedOption = 0;
        } else {
          self.selectedOption = (self.selectedOption === elems.length -1 ?
            self.selectedOption :
            self.selectedOption + 1);
        }
        break;
      }
      case (38): {
        if (!angular.isNumber(self.selectedOption)) {
          self.selectedOption = elems.length - 1;
        } else {
          self.selectedOption = self.selectedOption === 0 ?
            0 : self.selectedOption - 1;
        }
        break;
      }
    }
    elems[self.selectedOption].focus();
  };

  scope.getDropdownElement = function() {
    return self.dropdownMenu;
  };

  scope.focusToggleElement = function() {
    if (self.toggleElement) {
      self.toggleElement[0].focus();
    }
  };

  scope.$watch('isOpen', function(isOpen, wasOpen) {
    if (appendToBody && self.dropdownMenu) {
      var pos = $position.positionElements($element, self.dropdownMenu, 'bottom-left', true);
      var css = {
        top: pos.top + 'px',
        display: isOpen ? 'block' : 'none'
      };

      var rightalign = self.dropdownMenu.hasClass('dropdown-menu-right');
      if (!rightalign) {
        css.left = pos.left + 'px';
        css.right = 'auto';
      } else {
        css.left = 'auto';
        css.right = (window.innerWidth - (pos.left + $element.prop('offsetWidth'))) + 'px';
      }

      self.dropdownMenu.css(css);
    }

    $animate[isOpen ? 'addClass' : 'removeClass']($element, openClass).then(function() {
      if (angular.isDefined(isOpen) && isOpen !== wasOpen) {
        toggleInvoker($scope, { open: !!isOpen });
      }
    });

    if (isOpen) {
      if (self.dropdownMenuTemplateUrl) {
        $templateRequest(self.dropdownMenuTemplateUrl).then(function(tplContent) {
          templateScope = scope.$new();
          $compile(tplContent.trim())(templateScope, function(dropdownElement) {
            var newEl = dropdownElement;
            self.dropdownMenu.replaceWith(newEl);
            self.dropdownMenu = newEl;
          });
        });
      }

      scope.focusToggleElement();
      uibDropdownService.open(scope);
    } else {
      if (self.dropdownMenuTemplateUrl) {
        if (templateScope) {
          templateScope.$destroy();
        }
        var newEl = angular.element('<ul class="dropdown-menu"></ul>');
        self.dropdownMenu.replaceWith(newEl);
        self.dropdownMenu = newEl;
      }

      uibDropdownService.close(scope);
      self.selectedOption = null;
    }

    if (angular.isFunction(setIsOpen)) {
      setIsOpen($scope, isOpen);
    }
  });

  $scope.$on('$locationChangeSuccess', function() {
    if (scope.getAutoClose() !== 'disabled') {
      scope.isOpen = false;
    }
  });

  var offDestroy = $scope.$on('$destroy', function() {
    scope.$destroy();
  });
  scope.$on('$destroy', offDestroy);
}])

.directive('uibDropdown', function() {
  return {
    controller: 'UibDropdownController',
    link: function(scope, element, attrs, dropdownCtrl) {
      dropdownCtrl.init();
    }
  };
})

.directive('uibDropdownMenu', function() {
  return {
    restrict: 'AC',
    require: '?^uibDropdown',
    link: function(scope, element, attrs, dropdownCtrl) {
      if (!dropdownCtrl || angular.isDefined(attrs.dropdownNested)) {
        return;
      }

      element.addClass('dropdown-menu');

      var tplUrl = attrs.templateUrl;
      if (tplUrl) {
        dropdownCtrl.dropdownMenuTemplateUrl = tplUrl;
      }

      if (!dropdownCtrl.dropdownMenu) {
        dropdownCtrl.dropdownMenu = element;
      }
    }
  };
})

.directive('uibKeyboardNav', function() {
  return {
    restrict: 'A',
    require: '?^uibDropdown',
    link: function(scope, element, attrs, dropdownCtrl) {
      element.bind('keydown', function(e) {
        if ([38, 40].indexOf(e.which) !== -1) {
          e.preventDefault();
          e.stopPropagation();

          var elems = dropdownCtrl.dropdownMenu.find('a');

          switch (e.which) {
            case (40): { // Down
              if (!angular.isNumber(dropdownCtrl.selectedOption)) {
                dropdownCtrl.selectedOption = 0;
              } else {
                dropdownCtrl.selectedOption = dropdownCtrl.selectedOption === elems.length -1 ?
                  dropdownCtrl.selectedOption : dropdownCtrl.selectedOption + 1;
              }
              break;
            }
            case (38): { // Up
              if (!angular.isNumber(dropdownCtrl.selectedOption)) {
                dropdownCtrl.selectedOption = elems.length - 1;
              } else {
                dropdownCtrl.selectedOption = dropdownCtrl.selectedOption === 0 ?
                  0 : dropdownCtrl.selectedOption - 1;
              }
              break;
            }
          }
          elems[dropdownCtrl.selectedOption].focus();
        }
      });
    }
  };
})

.directive('uibDropdownToggle', function() {
  return {
    require: '?^uibDropdown',
    link: function(scope, element, attrs, dropdownCtrl) {
      if (!dropdownCtrl) {
        return;
      }

      element.addClass('dropdown-toggle');

      dropdownCtrl.toggleElement = element;

      var toggleDropdown = function(event) {
        event.preventDefault();

        if (!element.hasClass('disabled') && !attrs.disabled) {
          scope.$apply(function() {
            dropdownCtrl.toggle();
          });
        }
      };

      element.bind('click', toggleDropdown);

      // WAI-ARIA
      element.attr({ 'aria-haspopup': true, 'aria-expanded': false });
      scope.$watch(dropdownCtrl.isOpen, function(isOpen) {
        element.attr('aria-expanded', !!isOpen);
      });

      scope.$on('$destroy', function() {
        element.unbind('click', toggleDropdown);
      });
    }
  };
});

/* Deprecated dropdown below */

angular.module('ui.bootstrap.dropdown')

.value('$dropdownSuppressWarning', false)

.service('dropdownService', ['$log', '$dropdownSuppressWarning', 'uibDropdownService', function($log, $dropdownSuppressWarning, uibDropdownService) {
  if (!$dropdownSuppressWarning) {
    $log.warn('dropdownService is now deprecated. Use uibDropdownService instead.');
  }

  angular.extend(this, uibDropdownService);
}])

.controller('DropdownController', ['$scope', '$element', '$attrs', '$parse', 'uibDropdownConfig', 'uibDropdownService', '$animate', '$uibPosition', '$document', '$compile', '$templateRequest', '$log', '$dropdownSuppressWarning', function($scope, $element, $attrs, $parse, dropdownConfig, uibDropdownService, $animate, $position, $document, $compile, $templateRequest, $log, $dropdownSuppressWarning) {
  if (!$dropdownSuppressWarning) {
    $log.warn('DropdownController is now deprecated. Use UibDropdownController instead.');
  }

  var self = this,
    scope = $scope.$new(), // create a child scope so we are not polluting original one
    templateScope,
    openClass = dropdownConfig.openClass,
    getIsOpen,
    setIsOpen = angular.noop,
    toggleInvoker = $attrs.onToggle ? $parse($attrs.onToggle) : angular.noop,
    appendToBody = false,
    keynavEnabled =false,
    selectedOption = null;


  $element.addClass('dropdown');

  this.init = function() {
    if ($attrs.isOpen) {
      getIsOpen = $parse($attrs.isOpen);
      setIsOpen = getIsOpen.assign;

      $scope.$watch(getIsOpen, function(value) {
        scope.isOpen = !!value;
      });
    }

    appendToBody = angular.isDefined($attrs.dropdownAppendToBody);
    keynavEnabled = angular.isDefined($attrs.uibKeyboardNav);

    if (appendToBody && self.dropdownMenu) {
      $document.find('body').append(self.dropdownMenu);
      $element.on('$destroy', function handleDestroyEvent() {
        self.dropdownMenu.remove();
      });
    }
  };

  this.toggle = function(open) {
    return scope.isOpen = arguments.length ? !!open : !scope.isOpen;
  };

  // Allow other directives to watch status
  this.isOpen = function() {
    return scope.isOpen;
  };

  scope.getToggleElement = function() {
    return self.toggleElement;
  };

  scope.getAutoClose = function() {
    return $attrs.autoClose || 'always'; //or 'outsideClick' or 'disabled'
  };

  scope.getElement = function() {
    return $element;
  };

  scope.isKeynavEnabled = function() {
    return keynavEnabled;
  };

  scope.focusDropdownEntry = function(keyCode) {
    var elems = self.dropdownMenu ? //If append to body is used.
      (angular.element(self.dropdownMenu).find('a')) :
      (angular.element($element).find('ul').eq(0).find('a'));

    switch (keyCode) {
      case (40): {
        if (!angular.isNumber(self.selectedOption)) {
          self.selectedOption = 0;
        } else {
          self.selectedOption = (self.selectedOption === elems.length -1 ?
            self.selectedOption :
          self.selectedOption + 1);
        }
        break;
      }
      case (38): {
        if (!angular.isNumber(self.selectedOption)) {
          self.selectedOption = elems.length - 1;
        } else {
          self.selectedOption = self.selectedOption === 0 ?
            0 : self.selectedOption - 1;
        }
        break;
      }
    }
    elems[self.selectedOption].focus();
  };

  scope.getDropdownElement = function() {
    return self.dropdownMenu;
  };

  scope.focusToggleElement = function() {
    if (self.toggleElement) {
      self.toggleElement[0].focus();
    }
  };

  scope.$watch('isOpen', function(isOpen, wasOpen) {
    if (appendToBody && self.dropdownMenu) {
      var pos = $position.positionElements($element, self.dropdownMenu, 'bottom-left', true);
      var css = {
        top: pos.top + 'px',
        display: isOpen ? 'block' : 'none'
      };

      var rightalign = self.dropdownMenu.hasClass('dropdown-menu-right');
      if (!rightalign) {
        css.left = pos.left + 'px';
        css.right = 'auto';
      } else {
        css.left = 'auto';
        css.right = (window.innerWidth - (pos.left + $element.prop('offsetWidth'))) + 'px';
      }

      self.dropdownMenu.css(css);
    }

    $animate[isOpen ? 'addClass' : 'removeClass']($element, openClass).then(function() {
      if (angular.isDefined(isOpen) && isOpen !== wasOpen) {
        toggleInvoker($scope, { open: !!isOpen });
      }
    });

    if (isOpen) {
      if (self.dropdownMenuTemplateUrl) {
        $templateRequest(self.dropdownMenuTemplateUrl).then(function(tplContent) {
          templateScope = scope.$new();
          $compile(tplContent.trim())(templateScope, function(dropdownElement) {
            var newEl = dropdownElement;
            self.dropdownMenu.replaceWith(newEl);
            self.dropdownMenu = newEl;
          });
        });
      }

      scope.focusToggleElement();
      uibDropdownService.open(scope);
    } else {
      if (self.dropdownMenuTemplateUrl) {
        if (templateScope) {
          templateScope.$destroy();
        }
        var newEl = angular.element('<ul class="dropdown-menu"></ul>');
        self.dropdownMenu.replaceWith(newEl);
        self.dropdownMenu = newEl;
      }

      uibDropdownService.close(scope);
      self.selectedOption = null;
    }

    if (angular.isFunction(setIsOpen)) {
      setIsOpen($scope, isOpen);
    }
  });

  $scope.$on('$locationChangeSuccess', function() {
    if (scope.getAutoClose() !== 'disabled') {
      scope.isOpen = false;
    }
  });

  var offDestroy = $scope.$on('$destroy', function() {
    scope.$destroy();
  });
  scope.$on('$destroy', offDestroy);
}])

.directive('dropdown', ['$log', '$dropdownSuppressWarning', function($log, $dropdownSuppressWarning) {
  return {
    controller: 'DropdownController',
    link: function(scope, element, attrs, dropdownCtrl) {
      if (!$dropdownSuppressWarning) {
        $log.warn('dropdown is now deprecated. Use uib-dropdown instead.');
      }

      dropdownCtrl.init();
    }
  };
}])

.directive('dropdownMenu', ['$log', '$dropdownSuppressWarning', function($log, $dropdownSuppressWarning) {
  return {
    restrict: 'AC',
    require: '?^dropdown',
    link: function(scope, element, attrs, dropdownCtrl) {
      if (!dropdownCtrl) {
        return;
      }

      if (!$dropdownSuppressWarning) {
        $log.warn('dropdown-menu is now deprecated. Use uib-dropdown-menu instead.');
      }

      element.addClass('dropdown-menu');

      var tplUrl = attrs.templateUrl;
      if (tplUrl) {
        dropdownCtrl.dropdownMenuTemplateUrl = tplUrl;
      }

      if (!dropdownCtrl.dropdownMenu) {
        dropdownCtrl.dropdownMenu = element;
      }
    }
  };
}])

.directive('keyboardNav', ['$log', '$dropdownSuppressWarning', function($log, $dropdownSuppressWarning) {
  return {
    restrict: 'A',
    require: '?^dropdown',
    link: function(scope, element, attrs, dropdownCtrl) {
      if (!$dropdownSuppressWarning) {
        $log.warn('keyboard-nav is now deprecated. Use uib-keyboard-nav instead.');
      }

      element.bind('keydown', function(e) {
        if ([38, 40].indexOf(e.which) !== -1) {
          e.preventDefault();
          e.stopPropagation();

          var elems = dropdownCtrl.dropdownMenu.find('a');

          switch (e.which) {
            case (40): { // Down
              if (!angular.isNumber(dropdownCtrl.selectedOption)) {
                dropdownCtrl.selectedOption = 0;
              } else {
                dropdownCtrl.selectedOption = dropdownCtrl.selectedOption === elems.length -1 ?
                  dropdownCtrl.selectedOption : dropdownCtrl.selectedOption + 1;
              }
              break;
            }
            case (38): { // Up
              if (!angular.isNumber(dropdownCtrl.selectedOption)) {
                dropdownCtrl.selectedOption = elems.length - 1;
              } else {
                dropdownCtrl.selectedOption = dropdownCtrl.selectedOption === 0 ?
                  0 : dropdownCtrl.selectedOption - 1;
              }
              break;
            }
          }
          elems[dropdownCtrl.selectedOption].focus();
        }
      });
    }
  };
}])

.directive('dropdownToggle', ['$log', '$dropdownSuppressWarning', function($log, $dropdownSuppressWarning) {
  return {
    require: '?^dropdown',
    link: function(scope, element, attrs, dropdownCtrl) {
      if (!$dropdownSuppressWarning) {
        $log.warn('dropdown-toggle is now deprecated. Use uib-dropdown-toggle instead.');
      }

      if (!dropdownCtrl) {
        return;
      }

      element.addClass('dropdown-toggle');

      dropdownCtrl.toggleElement = element;

      var toggleDropdown = function(event) {
        event.preventDefault();

        if (!element.hasClass('disabled') && !attrs.disabled) {
          scope.$apply(function() {
            dropdownCtrl.toggle();
          });
        }
      };

      element.bind('click', toggleDropdown);

      // WAI-ARIA
      element.attr({ 'aria-haspopup': true, 'aria-expanded': false });
      scope.$watch(dropdownCtrl.isOpen, function(isOpen) {
        element.attr('aria-expanded', !!isOpen);
      });

      scope.$on('$destroy', function() {
        element.unbind('click', toggleDropdown);
      });
    }
  };
}]);


;(function() {
  'use strict';

  angular.module('toastr', [])
    .factory('toastr', toastr);

  toastr.$inject = ['$animate', '$injector', '$document', '$rootScope', '$sce', 'toastrConfig', '$q'];

  function toastr($animate, $injector, $document, $rootScope, $sce, toastrConfig, $q) {
    var container;
    var index = 0;
    var toasts = [];

    var previousToastMessage = '';
    var openToasts = {};

    var containerDefer = $q.defer();

    var toast = {
      clear: clear,
      error: error,
      info: info,
      remove: remove,
      success: success,
      warning: warning
    };

    return toast;

    /* Public API */
    function clear(toast) {
      // Bit of a hack, I will remove this soon with a BC
      if (arguments.length === 1 && !toast) { return; }

      if (toast) {
        remove(toast.toastId);
      } else {
        for (var i = 0; i < toasts.length; i++) {
          remove(toasts[i].toastId);
        }
      }
    }

    function error(message, title, optionsOverride) {
      var type = _getOptions().iconClasses.error;
      return _buildNotification(type, message, title, optionsOverride);
    }

    function info(message, title, optionsOverride) {
      var type = _getOptions().iconClasses.info;
      return _buildNotification(type, message, title, optionsOverride);
    }

    function success(message, title, optionsOverride) {
      var type = _getOptions().iconClasses.success;
      return _buildNotification(type, message, title, optionsOverride);
    }

    function warning(message, title, optionsOverride) {
      var type = _getOptions().iconClasses.warning;
      return _buildNotification(type, message, title, optionsOverride);
    }

    function remove(toastId, wasClicked) {
      var toast = findToast(toastId);

      if (toast && ! toast.deleting) { // Avoid clicking when fading out
        toast.deleting = true;
        toast.isOpened = false;
        $animate.leave(toast.el).then(function() {
          if (toast.scope.options.onHidden) {
            toast.scope.options.onHidden(wasClicked);
          }
          toast.scope.$destroy();
          var index = toasts.indexOf(toast);
          delete openToasts[toast.scope.message];
          toasts.splice(index, 1);
          var maxOpened = toastrConfig.maxOpened;
          if (maxOpened && toasts.length >= maxOpened) {
            toasts[maxOpened - 1].open.resolve();
          }
          if (lastToast()) {
            container.remove();
            container = null;
            containerDefer = $q.defer();
          }
        });
      }

      function findToast(toastId) {
        for (var i = 0; i < toasts.length; i++) {
          if (toasts[i].toastId === toastId) {
            return toasts[i];
          }
        }
      }

      function lastToast() {
        return !toasts.length;
      }
    }

    /* Internal functions */
    function _buildNotification(type, message, title, optionsOverride)
    {
      if (angular.isObject(title)) {
        optionsOverride = title;
        title = null;
      }

      return _notify({
        iconClass: type,
        message: message,
        optionsOverride: optionsOverride,
        title: title
      });
    }

    function _getOptions() {
      return angular.extend({}, toastrConfig);
    }

    function _createOrGetContainer(options) {
      if(container) { return containerDefer.promise; }

      container = angular.element('<div></div>');
      container.attr('id', options.containerId);
      container.addClass(options.positionClass);
      container.css({'pointer-events': 'auto'});

      var target = angular.element(document.querySelector(options.target));

      if ( ! target || ! target.length) {
        throw 'Target for toasts doesn\'t exist';
      }

      $animate.enter(container, target).then(function() {
        containerDefer.resolve();
      });

      return containerDefer.promise;
    }

    function _notify(map) {
      var options = _getOptions();

      if (shouldExit()) { return; }

      var newToast = createToast();

      toasts.push(newToast);

      if (ifMaxOpenedAndAutoDismiss()) {
        var oldToasts = toasts.slice(0, (toasts.length - options.maxOpened));
        for (var i = 0, len = oldToasts.length; i < len; i++) {
          remove(oldToasts[i].toastId);
        }
      }

      if (maxOpenedNotReached()) {
        newToast.open.resolve();
      }

      newToast.open.promise.then(function() {
        _createOrGetContainer(options).then(function() {
          newToast.isOpened = true;
          if (options.newestOnTop) {
            $animate.enter(newToast.el, container).then(function() {
              newToast.scope.init();
            });
          } else {
            var sibling = container[0].lastChild ? angular.element(container[0].lastChild) : null;
            $animate.enter(newToast.el, container, sibling).then(function() {
              newToast.scope.init();
            });
          }
        });
      });

      return newToast;

      function ifMaxOpenedAndAutoDismiss() {
        return options.autoDismiss && options.maxOpened && toasts.length > options.maxOpened;
      }

      function createScope(toast, map, options) {
        if (options.allowHtml) {
          toast.scope.allowHtml = true;
          toast.scope.title = $sce.trustAsHtml(map.title);
          toast.scope.message = $sce.trustAsHtml(map.message);
        } else {
          toast.scope.title = map.title;
          toast.scope.message = map.message;
        }

        toast.scope.toastType = toast.iconClass;
        toast.scope.toastId = toast.toastId;
        toast.scope.extraData = options.extraData;

        toast.scope.options = {
          extendedTimeOut: options.extendedTimeOut,
          messageClass: options.messageClass,
          onHidden: options.onHidden,
          onShown: options.onShown,
          onTap: options.onTap,
          progressBar: options.progressBar,
          tapToDismiss: options.tapToDismiss,
          timeOut: options.timeOut,
          titleClass: options.titleClass,
          toastClass: options.toastClass
        };

        if (options.closeButton) {
          toast.scope.options.closeHtml = options.closeHtml;
        }
      }

      function createToast() {
        var newToast = {
          toastId: index++,
          isOpened: false,
          scope: $rootScope.$new(),
          open: $q.defer()
        };
        newToast.iconClass = map.iconClass;
        if (map.optionsOverride) {
          angular.extend(options, cleanOptionsOverride(map.optionsOverride));
          newToast.iconClass = map.optionsOverride.iconClass || newToast.iconClass;
        }

        createScope(newToast, map, options);

        newToast.el = createToastEl(newToast.scope);

        return newToast;

        function cleanOptionsOverride(options) {
          var badOptions = ['containerId', 'iconClasses', 'maxOpened', 'newestOnTop',
                            'positionClass', 'preventDuplicates', 'preventOpenDuplicates', 'templates'];
          for (var i = 0, l = badOptions.length; i < l; i++) {
            delete options[badOptions[i]];
          }

          return options;
        }
      }

      function createToastEl(scope) {
        var angularDomEl = angular.element('<div toast></div>'),
          $compile = $injector.get('$compile');
        return $compile(angularDomEl)(scope);
      }

      function maxOpenedNotReached() {
        return options.maxOpened && toasts.length <= options.maxOpened || !options.maxOpened;
      }

      function shouldExit() {
        var isDuplicateOfLast = options.preventDuplicates && map.message === previousToastMessage;
        var isDuplicateOpen = options.preventOpenDuplicates && openToasts[map.message];

        if (isDuplicateOfLast || isDuplicateOpen) {
          return true;
        }

        previousToastMessage = map.message;
        openToasts[map.message] = true;

        return false;
      }
    }
  }
}());

(function() {
  'use strict';

  angular.module('toastr')
    .constant('toastrConfig', {
      allowHtml: false,
      autoDismiss: false,
      closeButton: false,
      closeHtml: '<button>&times;</button>',
      containerId: 'toast-container',
      extendedTimeOut: 1000,
      iconClasses: {
        error: 'toast-error',
        info: 'toast-info',
        success: 'toast-success',
        warning: 'toast-warning'
      },
      maxOpened: 0,
      messageClass: 'toast-message',
      newestOnTop: true,
      onHidden: null,
      onShown: null,
      onTap: null,
      positionClass: 'toast-top-right',
      preventDuplicates: false,
      preventOpenDuplicates: false,
      progressBar: false,
      tapToDismiss: true,
      target: 'body',
      templates: {
        toast: 'directives/toast/toast.html',
        progressbar: 'directives/progressbar/progressbar.html'
      },
      timeOut: 5000,
      titleClass: 'toast-title',
      toastClass: 'toast'
    });
}());

(function() {
  'use strict';

  angular.module('toastr')
    .directive('progressBar', progressBar);

  progressBar.$inject = ['toastrConfig'];

  function progressBar(toastrConfig) {
    return {
      replace: true,
      require: '^toast',
      templateUrl: function() {
        return toastrConfig.templates.progressbar;
      },
      link: linkFunction
    };

    function linkFunction(scope, element, attrs, toastCtrl) {
      var intervalId, currentTimeOut, hideTime;

      toastCtrl.progressBar = scope;

      scope.start = function(duration) {
        if (intervalId) {
          clearInterval(intervalId);
        }

        currentTimeOut = parseFloat(duration);
        hideTime = new Date().getTime() + currentTimeOut;
        intervalId = setInterval(updateProgress, 10);
      };

      scope.stop = function() {
        if (intervalId) {
          clearInterval(intervalId);
        }
      };

      function updateProgress() {
        var percentage = ((hideTime - (new Date().getTime())) / currentTimeOut) * 100;
        element.css('width', percentage + '%');
      }

      scope.$on('$destroy', function() {
        // Failsafe stop
        clearInterval(intervalId);
      });
    }
  }
}());

(function() {
  'use strict';

  angular.module('toastr')
    .controller('ToastController', ToastController);

  function ToastController() {
    this.progressBar = null;

    this.startProgressBar = function(duration) {
      if (this.progressBar) {
        this.progressBar.start(duration);
      }
    };

    this.stopProgressBar = function() {
      if (this.progressBar) {
        this.progressBar.stop();
      }
    };
  }
}());

(function() {
  'use strict';

  angular.module('toastr')
    .directive('toast', toast);

  toast.$inject = ['$injector', '$interval', 'toastrConfig', 'toastr'];

  function toast($injector, $interval, toastrConfig, toastr) {
    return {
      replace: true,
      templateUrl: function() {
        return toastrConfig.templates.toast;
      },
      controller: 'ToastController',
      link: toastLinkFunction
    };

    function toastLinkFunction(scope, element, attrs, toastCtrl) {
      var timeout;

      scope.toastClass = scope.options.toastClass;
      scope.titleClass = scope.options.titleClass;
      scope.messageClass = scope.options.messageClass;
      scope.progressBar = scope.options.progressBar;

      if (wantsCloseButton()) {
        var button = angular.element(scope.options.closeHtml),
          $compile = $injector.get('$compile');
        button.addClass('toast-close-button');
        button.attr('ng-click', 'close(true, $event)');
        $compile(button)(scope);
        element.prepend(button);
      }

      scope.init = function() {
        if (scope.options.timeOut) {
          timeout = createTimeout(scope.options.timeOut);
        }
        if (scope.options.onShown) {
          scope.options.onShown();
        }
      };

      element.on('mouseenter', function() {
        hideAndStopProgressBar();
        if (timeout) {
          $interval.cancel(timeout);
        }
      });

      scope.tapToast = function () {
        if (angular.isFunction(scope.options.onTap)) {
          scope.options.onTap();
        }
        if (scope.options.tapToDismiss) {
          scope.close(true);
        }
      };

      scope.close = function (wasClicked, $event) {
        if ($event && angular.isFunction($event.stopPropagation)) {
          $event.stopPropagation();
        }
        toastr.remove(scope.toastId, wasClicked);
      };

      element.on('mouseleave', function() {
        if (scope.options.timeOut === 0 && scope.options.extendedTimeOut === 0) { return; }
        scope.$apply(function() {
          scope.progressBar = scope.options.progressBar;
        });
        timeout = createTimeout(scope.options.extendedTimeOut);
      });

      function createTimeout(time) {
        toastCtrl.startProgressBar(time);
        return $interval(function() {
          toastCtrl.stopProgressBar();
          toastr.remove(scope.toastId);
        }, time, 1);
      }

      function hideAndStopProgressBar() {
        scope.progressBar = false;
        toastCtrl.stopProgressBar();
      }

      function wantsCloseButton() {
        return scope.options.closeHtml;
      }
    }
  }
}());

angular.module("toastr").run(["$templateCache", function($templateCache) {$templateCache.put("directives/progressbar/progressbar.html","<div class=\"toast-progress\"></div>\n");
$templateCache.put("directives/toast/toast.html","<div class=\"{{toastClass}} {{toastType}}\" ng-click=\"tapToast()\">\n  <div ng-switch on=\"allowHtml\">\n    <div ng-switch-default ng-if=\"title\" class=\"{{titleClass}}\" aria-label=\"{{title}}\">{{title}}</div>\n    <div ng-switch-default class=\"{{messageClass}}\" aria-label=\"{{message}}\">{{message}}</div>\n    <div ng-switch-when=\"true\" ng-if=\"title\" class=\"{{titleClass}}\" ng-bind-html=\"title\"></div>\n    <div ng-switch-when=\"true\" class=\"{{messageClass}}\" ng-bind-html=\"message\"></div>\n  </div>\n  <progress-bar ng-if=\"progressBar\"></progress-bar>\n</div>\n");}]);
;(function (angular) {

    angular.module('admin', [
        'ui.router',
        'ngResource',
        'ngAnimate',
        'ngCookies',
        'ui.bootstrap.dropdown',
        'angular-jwt',
        'toastr',
        'siteConfig',
        'angular-pikaday'
    ]);

})(angular);

;(function (module) {

    module.config(Config);
    module.run(Run);

    Config.$inject = ['$locationProvider', '$resourceProvider', '$httpProvider'];

    function Config($locationProvider, $resourceProvider, $httpProvider) {

        $locationProvider.html5Mode(true);

        $resourceProvider.defaults.stripTrailingSlashes = false;

        $httpProvider.interceptors.push('authInterceptor');

    }

    Run.$inject = ['$document', '$location', '$rootScope', '$cookies', 'jwtHelper', 'USER'];

    function Run($document, $location, $rootScope, $cookies, jwtHelper, USER) {

        // Add user to root scope if found in local storage
        $rootScope.user = USER;

        $rootScope.$on('$locationChangeStart', function (event, next, current) {

            var jwt              = $cookies.get('jwt'),
                logged_in        = jwt && !jwtHelper.isTokenExpired(jwt),
                account_complete = $rootScope.user !== null,
                is_logging_in    = $location.path() === '/login',
                is_registering   = $location.path() === '/register';

            // Redirect to login if not authenticated
            if (!logged_in && !is_logging_in) {
                $location.path('/login');
            }

            // Redirect to /register if authenticated, but account not complete
            if (logged_in && !account_complete && !is_registering) {
                $location.path('/register');
            }

            //Restrict login and register pages if already logged in and registered
            if ((logged_in && is_logging_in) || account_complete && is_registering) {
                $location.path('/home');
            }

        });

        $rootScope.$on('$stateChangeSuccess', function () {
            $document[0].body.scrollTop = $document[0].documentElement.scrollTop = 0;
        });

    }

})(angular.module('admin'));
;(function(module) {

    module.config(Config);

    Config.$inject = ['$stateProvider', '$urlRouterProvider'];

    function Config($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('/requests/new');

        $stateProvider
            .state('main', {
                abstract: true,
                url: '/',
                templateUrl: '/build/ng-app/common/main-layout.html'
            })
            .state('main.home', {
                url: '^/home',
                template: 'home'
            });

        // Authentication
        $stateProvider
            .state('auth', {
                abstract: true,
                url: '/auth',
                templateUrl: '/build/ng-app/common/auth-layout.html'
            })
            .state('auth.login', {
                url: '^/login',
                template: '<login></login>'
            })
            .state('auth.register', {
                url: '^/register',
                template: '<register></register>'
            })
            .state('auth.logout', {
                url: '^/logout',
                template: '<logout></logout>'
            });

        // Support Requests
        $stateProvider
            .state('main.requests', {
                url: '^/requests',
                template: '<requests-list></requests-list>'
            })
            .state('main.requests_new', {
                url: '^/requests/new',
                template: '<requests-new></requests-new>'
            })
            .state('main.requests_graphics', {
                url: '^/requests/graphics',
                template: '<requests-graphics></requests-graphics>'
            })
            .state('main.requests_photo', {
                url: '^/requests/photo',
                template: '<requests-photo></requests-photo>'
            })
            .state('main.requests_website', {
                url: '^/requests/website',
                template: '<requests-website></requests-website>'
            })
            .state('main.requests_facility', {
                url: '^/requests/facility',
                template: '<requests-facility></requests-facility>'
            });

    }

})(angular.module('admin'));
;(function (module) {
    'use strict';

    module.directive('login', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/auth/login.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));
;(function (module) {
    'use strict';

    module.directive('logout', directive);

    function directive() {
        return {
            template:         '',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {}
        };
    }

    Controller.$inject = ['$location', '$cookies'];

    function Controller($location, $cookies) {

        $cookies.remove('jwt');
        $cookies.remove('user');
        $location.path('/login');

    }

})(angular.module('admin'));
;(function (module) {
    'use strict';

    module.directive('register', directive);

    function directive() {
        return {
            templateUrl:      '/build/ng-app/auth/register.html',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {}
        };
    }

    Controller.$inject = ['$http'];

    function Controller($http) {

        var vm            = this;
        vm.email_username = null;
        vm.email_sent     = false;
        vm.send           = send;

        function send() {

            var data = { username: vm.email_username };

            $http.post('/auth/register', data)
                .success(function () {
                    vm.email_sent = true;
                })
                .error(function () {
                    alert('Error occurred')
                });

        }

    }

})(angular.module('admin'));
;(function (module) {
    'use strict';

    module.factory('campusesService', service);

    service.$inject = ['$http'];

    function service($http) {

        return {

            all: function () {
                return $http.get('/api/campuses');
            }

        };

    }

})(angular.module('admin'));

;(function (module) {

    module.animation('.slide-toggle', animation);

    animation.$inject = ['$animateCss'];

    function animation($animateCss) {
        var lastId = 0;
        var _cache = {};

        function getId(el) {
            var id = el[0].getAttribute("data-slide-toggle");
            if (!id) {
                id = ++lastId;
                el[0].setAttribute("data-slide-toggle", id);
            }
            return id;
        }

        function getState(id) {
            var state = _cache[id];
            if (!state) {
                state = {};
                _cache[id] = state;
            }
            return state;
        }

        function generateRunner(closing, state, animator, element, doneFn) {
            return function () {
                state.animating = true;
                state.animator = animator;
                state.doneFn = doneFn;
                animator.start().finally(function () {
                    if (closing && state.doneFn === doneFn) {
                        element[0].style.height = '';
                    }
                    state.animating = false;
                    state.animator = undefined;
                    state.doneFn();
                });
            }
        }

        return {
            addClass: function (element, className, doneFn) {
                if (className == 'ng-hide') {
                    var state = getState(getId(element));
                    var height = (state.animating && state.height) ?
                        state.height : element[0].offsetHeight;

                    var animator = $animateCss(element, {
                        from: {
                            height: height + 'px',
                            opacity: 1
                        },
                        to: {
                            height: '0px',
                            opacity: 0
                        }
                    });
                    if (animator) {
                        if (state.animating) {
                            state.doneFn =
                                generateRunner(true,
                                    state,
                                    animator,
                                    element,
                                    doneFn);
                            return state.animator.end();
                        } else {
                            state.height = height;
                            return generateRunner(true,
                                state,
                                animator,
                                element,
                                doneFn)();
                        }
                    }
                }
                doneFn();
            },
            removeClass: function (element, className, doneFn) {
                if (className == 'ng-hide') {
                    var state = getState(getId(element));
                    var height = (state.animating && state.height) ?
                        state.height : element[0].offsetHeight;

                    var animator = $animateCss(element, {
                        from: {
                            height: '0px',
                            opacity: 0
                        },
                        to: {
                            height: height + 'px',
                            opacity: 1
                        }
                    });

                    if (animator) {
                        if (state.animating) {
                            state.doneFn = generateRunner(false,
                                state,
                                animator,
                                element,
                                doneFn);
                            return state.animator.end();
                        } else {
                            state.height = height;
                            return generateRunner(false,
                                state,
                                animator,
                                element,
                                doneFn)();
                        }
                    }
                }
                doneFn();
            }
        };
    }

})(angular.module('admin'));
;(function (module) {

    module.factory('apiUrlInterceptor', factory);

    factory.$inject = ['config'];

    function factory(config) {

        return {
            request: request
        };

        function request(requestConfig) {
            var url = requestConfig.url;

            // If we're requesting a template
            if (url.indexOf('.html') > -1) {
                return requestConfig;
            }

            // Otherwise, prepend base API url
            requestConfig.url = config.api_uri + url;
            requestConfig.withCredentials = true;

            return requestConfig;
        }

    }

}(angular.module('admin')));
;(function (module) {

    module.factory('authInterceptor', factory);

    factory.$inject = ['$q', '$cookies'];

    function factory($q, $cookies) {

        return {
            request:  request,
            response: response
        };

        function request(requestConfig) {

            var jwt = $cookies.get('jwt');

            if (/\.html$/.test(requestConfig.url)) {
                return requestConfig;
            }

            requestConfig.headers = requestConfig.headers || {};

            if (jwt) {
                requestConfig.headers.Authorization = 'Bearer ' + jwt;
            }

            return requestConfig;
        }

        function response(response) {

            if (response.status === 401) {
                // TODO: Handle case where user is not authenticated
            }

            return response || $q.when(response);

        }

    }

}(angular.module('admin')));
;(function (module, moment) {
    'use strict';

    module.directive('deliveryDates', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/delivery-dates.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: {
                dates: '=',
                exclude: '@',
                deliverBy: '=',
                eventDate: '='
            },
            scope: {}
        };
    }

    Controller.$inject = [];

    function Controller() {

        var vm = this;
        vm.set_date = set_date;
        vm.subtract_days_from_event_date = subtract_days_from_event_date;
        vm.is_visible = is_visible;
        vm.show_divider = show_divider;

        function set_date(d) {
            d = (typeof d) === 'object' ? d : subtract_days_from_event_date(d);
            vm.deliverBy = d;
        }

        function subtract_days_from_event_date(num_days) {
            if (vm.eventDate) {
                return moment(vm.eventDate).subtract(num_days, 'days').toDate();
            }
            return null;
        }

        function is_visible() {
            return vm.eventDate
                || has_dates();
        }

        function show_divider() {
            return vm.eventDate && has_dates()
        }

        function has_dates() {
            return (vm.dates.length > 1)
                || (vm.dates.length === 1 && vm.dates[0].slug !== vm.exclude);
        }

    }

})(angular.module('admin'), moment);
;(function (module) {
    'use strict';

    module.directive('requestsFacility', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-facility.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));

;(function (module) {
    'use strict';

    module.directive('requestsGeneral', directive);

    function directive() {
        return {
            templateUrl:      '/build/ng-app/requests/requests-general.html?v=1',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {
                type:               '@',
                title:              '@',
                subtitle:           '@',
                header:             '@',
                subjectLabel:       '@',
                subjectPlaceholder: '@',
                dateLabel:          '@',
                descriptionLabel:   '@',
                image:              '@',
                showCampus:         '@'
            }
        };
    }

    Controller.$inject = ['$scope', '$sce', '$state', 'requestsService', 'campusesService', 'toastr'];

    function Controller($scope, $sce, $state, requestsService, campusesService, Notification) {

        var vm         = this;
        vm.ticket      = { type: vm.type, title: vm.title };
        vm.submit      = submit;
        vm.hero_header = $sce.trustAsHtml(this.header);

        init();

        function init() {
            campusesService.all().then(function (data) {
                vm.campuses = data.data;
            });
        }

        function submit() {

            var data = { ticket: vm.ticket };

            vm.is_sending = true;

            requestsService.save(data).success(function () {
                Notification.success('Request sent. Thank you!');
                $state.go('main.requests_new');
            }).error(function () {
                Notification.error('An error occurred. Your request could not be sent.');
                vm.is_sending = false;
            });
        }

    }

})(angular.module('admin'));

;(function (module, angular) {
    'use strict';

    module.directive('requestsGraphics', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-graphics.html?v=1',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    Controller.$inject = ['$scope', '$state', 'requestsService', 'toastr', 'USER'];

    function Controller($scope, $state, requestsService, Notification, USER) {

        var vm = this;
        vm.user = USER;
        vm.subject = '';
        vm.event_date = null;
        vm.toggle_item = toggle_item;
        vm.has_items_selected = has_items_selected;
        vm.submit = submit;
        vm.helper_dates = [];
        vm.items = {};

        init();

        function init() {
            create_items();
        }

        function create_items() {
            create_item('graphics_invite_card', 'Invite Card', 'What should your invite card say?');
            create_item('graphics_flyer', 'Flyer', 'What should it say?');
            create_item('graphics_seat_card', 'Seatback Card', 'Briefly describe the purpose of your card.');
            create_item('graphics_slide', 'Slide In Service', 'What should your slide say?');
            create_item('graphics_apparel', 'T-Shirt/Apparel', 'Briefly describe your t-shirt idea.');
            create_item('graphics_sign', 'Signage', 'What should your sign say?'); // TODO: Should say, "When do you need it installed?"
            create_item('graphics_website', 'Website Promo', 'What needs to be added or changed on the website?');
            create_item('graphics_other', 'Other Project', 'Please describe your project?');
        }

        function create_item(ident, title, description_label) {
            vm.items[ident] = {
                title: title,
                meta: {
                    description_label: description_label
                }

            };
        }

        function submit() {
            var data = {
                requests: gather_requests()
            };

            vm.is_sending = true;

            requestsService.batch_save(data).success(function () {
                Notification.success('Request sent. Thank you!');
                $state.go('main.requests_new');
            }).error(function() {
                Notification.error('An error occurred. Your request could not be sent.');
                vm.is_sending = false;
            });
        }

        function gather_requests() {
            var result = [];

            angular.forEach(vm.items, function (item, key) {
                if (item.meta.selected) {
                    item.meta.type = key;
                    item.subject = vm.subject;
                    result.push(item);
                }
            });

            return result;
        }

        function toggle_item(item) {
            item.meta.selected = !item.meta.selected;
        }

        function has_items_selected() {
            var result = false;
            angular.forEach(vm.items, function (item) {
                if (item.meta.selected) {
                    return result = true;
                }
            });
            return result;
        }

        function update_helper_dates() {
            var helper_dates = [];
            angular.forEach(vm.items, function (value, key) {
                if (value.deliver_by && value.meta.selected) {
                    helper_dates.push({
                        slug: key,
                        title: value.title,
                        deliver_by: value.deliver_by
                    });
                }
            });
            vm.helper_dates = helper_dates;
        }

        $scope.$watch('vm.items', update_helper_dates, true);

    }

})(angular.module('admin'), angular);
;(function (module) {
    'use strict';

    module.directive('requestsList', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-list.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    Controller.$inject = ['requestsService'];

    function Controller(requestsService) {

        var vm = this;

        init();

        function init() {
            requestsService.all().then(function(response) {
                vm.tickets = response.data.tickets;
            });
        }

    }

})(angular.module('admin'));
;(function (module) {
    'use strict';

    module.directive('requestsNew', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-new.html?v=2',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    function Controller() {

        var vm = this;

        vm.cards = [
            {
                type: 'tech-support',
                title: 'Tech Support',
                description: 'Computer, email, printing, and Internet issues.',
                image: '',
                staffer: 'joe-filipowicz',
                submit_text: 'helpdesk@faithpromise.org',
                submit_link: 'mailto:helpdesk@faithpromise.org'
            },
            {
                type: 'worship-tech',
                title: 'Worship Tech',
                description: 'Mics, projectors, lights, or other worship equipment issues.',
                image: '',
                staffer: 'emily-carringer',
                submit_link: 'http://www.faithpromiseweb.com/request/tech-maintenance-request/'
            },
            {
                type: 'graphics',
                title: 'Graphics',
                description: 'Flyers, brochures, invite cards, t-shirts, logos, slides, etc.',
                image: '',
                staffer: 'heather-burson'
            },
            {
                type: 'video',
                title: 'Video',
                description: 'Video shoots for event promotion, interviews, short films, etc.',
                image: '',
                staffer: 'adam-chapman',
                submit_link: 'http://www.faithpromiseweb.com/request/video-request-2/'
            },
            {
                type: 'website',
                title: 'Website Change',
                description: 'Request an update or report an issue with our website.',
                image: '',
                staffer: 'brad-roberts'
            },
            {
                type: 'resources',
                title: 'FP Resources',
                description: 'Promote a t-shirt, CD, book, or other item for sale.',
                image: '',
                staffer: 'mallory-ellis',
                submit_link: 'http://www.faithpromiseweb.com/request/fpresources-sales-request/'
            },
            {
                type: 'facility',
                title: 'Facility',
                description: 'From repairs and replacements to construction. We\'ve got you covered.',
                image: '',
                staffer: 'marti-willen'
            }
        ];

        init();

        function init() {

        }

    }

})(angular.module('admin'));
;(function (module) {
    'use strict';

    module.directive('requestsPhoto', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-photo.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));

;(function (module) {
    'use strict';

    module.directive('requestsWebsite', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-website.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));

;(function(module) {
    'use strict';

    module.factory('requestsService', service);

    service.$inject = ['$http'];

    function service($http) {

        return {

            all: function() {
                return $http.get('/api/requests');
            },

            save: function(data) {
                return $http.post('/api/requests', data);
            },

            batch_save: function(data) {
                return $http.post('/api/requests/batch', data);
            }
        };

    }

})(angular.module('admin'));
