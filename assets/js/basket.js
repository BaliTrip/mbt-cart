/**
 * Select map location widget.
 * The widget writes the coordinates to hidden inputs when enter address into text input or move marker on the map.
 *
 * @see https://developers.google.com/maps/documentation/javascript/tutorial
 *
 * @param {Object}  options
 * @param {String|jQuery|HTMLInputElement} options.id Button selector
 * @param {String|jQuery|HTMLInputElement} options.basket_container Button selector
 */
(function ($) {

  var getBasketItems = function () {
    basketStorage = localStorage.getItem('basket')
    return basketStorage ? JSON.parse(basketStorage) : []
  }
  var getBasketSum = function (items) {
    items = items || getBasketItems()
    return items.reduce(function (a, b) {
      return a + b.price * b.quantity
    }, 0)
  }

  $.fn.initBasketButton = function (options) {
    options.beforeSave = options.beforeSave || function () { return true }
    var self = this
    $(document).ready(function () {
      $(document).on('click', options.button_selector, function (e) {
        console.log('sent event: basket:add ' + options.basket_selector)
        e.preventDefault()
        var item = $(this).data('item'),
          basketItems = getBasketItems()
        if (options.beforeSave(item, basketItems)) {
          var exists = false
          for (var i = 0; i < basketItems.length; i++) {
            if (basketItems[i].id === item.id) {
              basketItems[i].quantity += item.quantity
              exists = true
              break
            }
          }
          if (!exists) {
            basketItems.push(item)
          }
        }
        localStorage.setItem('basket', JSON.stringify(basketItems))
        $(options.basket_selector).trigger('basket:add', item)
        $(this).addClass('in-basket')
        UIkit.notification({
          message: options.success_message || 'jsOptions.success_message',
          status: 'success',
          pos: 'top-center',
          timeout: 5000
        });
      })
    })
  }
  $.fn.initBasket = function (options) {
    options.beforeSave = options.beforeSave || function () { return true }
    var self = this
    $(document).ready(function () {
      var refreshBasketInfo = function () {
        var items = getBasketItems(),
          html = ''
        if (items.length) {
          html = items.length + ' items ' + getBasketSum(items) + ' rp'
        } else {
          html = options.empty_message
        }
        $(options.selector).find('.basket-info').html(html)
      }
      $(document).on('basket:add', options.selector, function (event, item) {
        console.log('received: basket:add')
        refreshBasketInfo()
      })
      refreshBasketInfo()
    })
  }
})(jQuery)
