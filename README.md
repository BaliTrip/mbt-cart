
Виджет корзины

```php
<?= \balitrip\mbtcart\BasketWidget::widget(['id' => 'basket']) ?>
```

Виджет кнопки

```php
<?= \balitrip\mbtcart\ButtonWidget::widget([
    'item_id' => $model->id,
    'item_price' => $model->price,
    'item_data' => [
        'title'=> $model->name,
        'description'=> $model->shortInfo,
        'image'=> $model->preview,
    ],    
    'options' => [
        'class' => 'uk-button uk-button-small uk-button-primary',
    ],
]) ?>
```
