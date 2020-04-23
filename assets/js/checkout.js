'use strict';

var app = new Vue({
  el: '#checkout',
  mounted: function mounted() {
    this.basketItems = this.getStorageItems();
  },
  data: {
    basketItems: [],
    deliveries: DELIVERIES
  },
  computed: {
    total: function total() {
      return this.basketItems.reduce(function (a, b) {
        return a + b.price * b.quantity;
      }, 0);
    },
    tickets: function tickets() {
      return this.basketItems.map(function (item) {
        return item.id;
      }).join(',');
    },
    ticketsQuantity: function ticketsQuantity() {
      return this.basketItems.map(function (item) {
        return {
          id: item.id,
          quantity: item.quantity
        };
      });
    }
  },
  methods: {
    getStorageItems: function getStorageItems() {
      var basketStorage = localStorage.getItem('basket');
      return basketStorage ? JSON.parse(basketStorage) : [];
    },
    setStorageItems: function setStorageItems(items) {
      if (typeof items === 'array') {
        items = [];
      }

      localStorage.setItem('basket', JSON.stringify(items));
    },
    increase: function increase(itemId) {
      for (var i = 0; i < this.basketItems.length; i++) {
        if (this.basketItems[i].id === itemId) {
          this.basketItems[i].quantity++;
        }
      }

      this.setStorageItems(this.basketItems);
    },
    decrease: function increase(itemId) {
      for (var i = 0; i < this.basketItems.length; i++) {
        if (this.basketItems[i].id === itemId) {
          if (this.basketItems[i].quantity > 1) {
            this.basketItems[i].quantity--;
          }
        }
      }

      this.setStorageItems(this.basketItems);
    },
    selectDelivery: function selectDelivery(delivery) {
      this.basketItems = this.basketItems.filter(function (item) {
        return !item.delivery;
      });
      this.basketItems.push({
        id: delivery.id,
        data: {
          title: delivery.name,
          description: ''
        },
        delivery: true,
        price: delivery.price,
        quantity: 1
      });
      this.setStorageItems(this.basketItems);
    },
    deliveryExists: function deliveryExists(items, delivery) {
      return items.some(function (item) {
        return item.id === delivery.id;
      });
    },
    checkout: function checkout() {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', API_URL + '/v1/orders/form-submit/?preorder=true&lang=' + CLIENT_LANG + '&ticket_id=' + this.tickets, true);
      xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status >= 200) {
          var response = JSON.parse(xhr.responseText);

          if (xhr.status === 201 || xhr.status === 200) {
            localStorage.removeItem('basket');
            localStorage.setItem('orders-count', localStorage.getItem('orders-count') + 1);
            setTimeout(function () {
              window.location.href = response.redirect;
            }, 100);
          } else {
            alert('Возникла непредвиденная ошибка при оформлении заказа, пожалуйста, попробуйте позже или обратитесь к нашему менеджеру для оформления заказа.');
          }
        }
      };

      xhr.send(JSON.stringify({
        OrderForm: {
          ticketsQuantity: this.ticketsQuantity
        }
      }));
    },
    numberWithSpaces: function (x) {
      if (x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        return parts.join(".");
      }
      return x;
    },
    remove: function (itemId) {
      this.basketItems = this.basketItems.filter(function (item) {
        return item.id !== itemId;
      });
      this.setStorageItems(this.basketItems);
    }
  }
});
