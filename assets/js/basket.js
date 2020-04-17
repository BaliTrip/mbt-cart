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
  $.fn.initBasketButton = function (options) {
    options.beforeSave = options.beforeSave || function () { return true }
    var self = this
    $(document).ready(function () {
      $(document).on('click', options.button_selector, function (e) {
        console.log('sent event: basket:add '+ options.basket_selector)
        e.preventDefault()
        $(options.basket_selector).trigger('basket:add', $(this).data('item'))
        $(this).addClass('in-busket')
      })
    })
  }
  $.fn.initBasket = function (options) {
    options.beforeSave = options.beforeSave || function () { return true }
    var self = this

    $(document).ready(function () {
      var getBasketItems = function () {
        basketStorage = localStorage.getItem('basket')
        return basketStorage ? JSON.parse(basketStorage) : []
      }
      var getBasketSum = function (items) {
        items = items || getBasketItems()
        return items.reduce(function (a, b) {
          return a + b.price
        },0)
      }
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
        console.log(item)
        console.log('received: basket:add')
        basketItems = getBasketItems()
        if (options.beforeSave(item, basketItems)) {
          basketItems.push(item)
        }
        localStorage.setItem('basket', JSON.stringify(basketItems))
        refreshBasketInfo()
      })

      refreshBasketInfo()
    })
  }
})(jQuery)
