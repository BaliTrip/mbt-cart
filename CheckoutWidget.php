<?php


namespace balitrip\mbtcart;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class CheckoutWidget
 * @package balitrip\mbtcart
 *
 * @property Component $cart
 * @property array $options
 * @property string $currency Currency sign
 * @property int $company_id
 */
class CheckoutWidget extends Widget
{
    public $options = [];
    public $component = 'cart';
    public $currency = 'IDR';
    public $company_id;

    /**
     * @return null|object
     * @throws InvalidConfigException
     */
    protected function getCart()
    {
        return Yii::$app->get($this->component);
    }

    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->id ?: $this->getId();
        }
        parent::init();
    }

    /**
     * @return string
     * @throws InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function run()
    {
        $this->view->registerJsFile(YII_ENV_DEV ? 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js' : 'https://cdn.jsdelivr.net/npm/vue@2.6.11');

        $deliveries = new JsExpression(Json::encode($this->cart->getApiData([
            'company_id' => $this->company_id,
            'key' => 'delivery',
            'expand' => 'price',
            'lang' => Yii::$app->language,
        ])));

        $this->view->registerJs("CLIENT_LANG = '".Yii::$app->language."';var API_URL = '{$this->cart->apiUrl}'; var DELIVERIES = $deliveries",
            $this->view::POS_BEGIN);
        CheckoutAssets::register($this->view);

        return $this->render('checkout', ['currency' => $this->currency]);
    }
}
