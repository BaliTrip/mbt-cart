<?php


namespace balitrip\mbtcart;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class BasketWidget extends Widget
{
    public $jsOptions = [];
    public $options = [];
    public $id;
    public $apiUrl;
    public $empty;
    public $checkoutUrl;

    public function __construct($config = [])
    {
        if (!isset($config['empty'])) {
            $config['empty'] = Yii::t('app', 'BASKET_EMPTY_MESSAGE');
        }
        parent::__construct($config);
    }

    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->id ?: $this->getId();
        }
        $this->jsOptions['api_url'] = $this->apiUrl;
        $this->jsOptions['lang'] = Yii::$app->language;
        $this->jsOptions['selector'] = "#{$this->options['id']}";
        $this->jsOptions['empty_message'] = $this->empty;
        parent::init();
    }

    public function run()
    {
        Assets::register($this->view);
        $this->view->registerJs(new JsExpression('
            $("#'.$this->options['id'].'").initBasket('.Json::encode($this->jsOptions).');
        '));
        return Html::tag('div', Html::a('', $this->checkoutUrl, ['class' => 'basket-info']), $this->options);
    }
}
