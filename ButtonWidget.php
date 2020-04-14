<?php


namespace balitrip\mbtcart;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class ButtonWidget extends Widget
{
    public $basket_selector;
    public $button_selector;
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
        if (empty($this->button_selector) && !isset($this->jsOptions['button_selector'])) {
            $this->jsOptions['button_selector'] = "#$this->id";
        }
        if (empty($this->basket_selector) && !isset($this->jsOptions['basket_selector'])) {
            $this->jsOptions['basket_selector'] = "#basket";
        }
        parent::init();
    }

    public function run()
    {
        parent::run();
        Assets::register($this->view);
        $this->view->registerJs(new JsExpression('
            $("body").initBasketButton('.Json::encode($jsOptions).');
        '));
        return Html::button($this->label ?? Yii::t('app', 'Order'), $this->options);
    }
}
