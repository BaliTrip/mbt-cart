<?php

namespace balitrip\mbtcart;

use yii\web\AssetBundle;

/**
 * Mbt Cart widget assets class
 */
class CheckoutAssets extends AssetBundle
{
    public $sourcePath = '@vendor/balitrip/mbt-cart/assets';
    public $css = [];

    public $js = [
        'js/checkout.js',
    ];

    public $depends = [
    ];
}
