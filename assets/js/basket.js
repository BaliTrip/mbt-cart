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
        e.preventDefault()
        basketStorage = localStorage.getItem('basket')
        basketItems = basketStorage ? JSON.parse(basketStorage) : []
        var item = $(this).data('item')
        if (options.beforeSave(item, basketItems)) {
          basketItems.push(item)
        }
        localStorage.setItem(JSON.stringify(basketItems))
        $(options.basket_selector).trigger('basket:saved')
      })
    })
  }
})(jQuery)
