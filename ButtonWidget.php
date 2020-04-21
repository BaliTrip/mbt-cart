<?php


namespace balitrip\mbtcart;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class ButtonWidget extends Widget
{
    public $jsOptions = [];
    public $label;
    public $options = [];
    public $item_id;
    public $item_data;
    public $item_price = 0;

    public function __construct($config = [])
    {
        if (!isset($config['item_id'])) {
            throw new InvalidConfigException('Item id is required');
        }
        parent::__construct($config);
    }

    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        parent::init();
    }

    public function run()
    {
        Assets::register($this->view);
        $jsOption = ArrayHelper::merge([
            'basket_selector' => '#basket',
            'button_selector' => '.to-basket-button',
        ], $this->jsOptions);
        $this->view->registerJs(new JsExpression('
            $("body").initBasketButton('.Json::encode($jsOption).');
        '));
        $options = ArrayHelper::merge($this->options, [
            'data' => [
                'item' => [
                    'id' => $this->item_id,
                    'price' => $this->item_price,
                    'data' => $this->item_data,
                    'quantity'=>1
                ]
            ],
        ]);
        Html::addCssClass($options, 'to-basket-button');


        return Html::button($this->label ?? Yii::t('app', 'Order'), $options);
    }
}
