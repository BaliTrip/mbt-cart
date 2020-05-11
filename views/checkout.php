<?php

?>

<div id="checkout">
  <template v-if="basketItems.length">
    <table class="uk-table uk-table-divider uk-table-small uk-table-middle uk-table-condensed checkout-items">
      <thead>
      <tr>
        <th><?= Yii::t('app', 'CHECKOUT_ITEM_TITLE') ?></th>
        <th class="uk-text-right"><?= Yii::t('app', 'CHECKOUT_ITEM_PRICE') ?></th>
        <th class="uk-text-center"><?= Yii::t('app', 'CHECKOUT_ITEM_QUANTITY') ?></th>
        <th class="uk-text-right"><?= Yii::t('app', 'CHECKOUT_ITEM_SUMMARY') ?></th>
      </tr>
      </thead>
      <tbody>
      <template v-for="item in basketItems">
        <tr v-if="!item.delivery" class="checkout-item">
          <td>
            {{ item.data.title }}
            <template v-if="item.data.description">
              ({{ item.data.description }})
            </template>
          </td>
          <td class="uk-text-right">{{ numberWithSpaces(item.price) }} IDR</td>
          <td class="uk-text-center">
            <a href="#" @click.prevent="decrease(item.id)"
               class="uk-button uk-button-default uk-button-inverse uk-button-small"
               :class="{'uk-disabled': item.quantity == 1}">
              <i class="fa fa-minus"></i>
            </a>
            <div class="uk-button checkout-number">
              {{ item.quantity }}
            </div>
            <a href="#" @click.prevent="increase(item.id)"
               class="uk-button uk-button-default uk-button-inverse uk-button-small">
              <i class="fa fa-plus"></i>
            </a>
          </td>
          <td class="uk-text-right">{{ numberWithSpaces(item.price * item.quantity) }} IDR</td>
          <td class="uk-text-center"><i class="fa fa-trash" @click.prevent="remove(item.id)"></i></td>
        </tr>
      </template>
      </tbody>
    </table>
    <div class="checkout-deliveries">
      <div class="uk-child-width-1-4@s uk-grid-match" uk-grid>
        <div v-for="delivery in deliveries">
          <div class="uk-card uk-card-small uk-card-hover uk-card-body"
               @click.prevent="selectDelivery(delivery)"
               :class="deliveryExists(basketItems, delivery)?'uk-card-primary':'uk-card-default'">
            <h3 class="uk-card-title">
              <template v-if="deliveryExists(basketItems, delivery)">
                <span class="uk-float-right">
                  <i class="fa fa-circle"></i>
                </span>
              </template>
              <a class="uk-float-right" v-else><i class="fa fa-circle-o"></i></a>
              {{ delivery.name }}
            </h3>
            <div class="price">{{ numberWithSpaces(delivery.price) }} IDR</div>
            <div>{{ delivery.details }}</div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="checkout-total uk-text-center">
      <span>{{ numberWithSpaces(total) }} IDR</span>
    </div>
    <div class="checkout-submit uk-text-center uk-margin-top">
      <button class="uk-button uk-button-primary" @click.prevent="checkout"><?= Yii::t('app',
              'CHECKOUT_SUMBIT') ?></button>
    </div>
  </template>
  <div v-else>
      <?= Yii::t('app', 'CHECKOUT_EMPTY') ?>
  </div>
</div>
