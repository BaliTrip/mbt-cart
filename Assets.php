<?php

namespace balitrip\mbtcart;

use yii\web\AssetBundle;

/**
 * Mbt Cart widget assets class
 */
class Assets extends AssetBundle
{
    public $sourcePath = '@vendor/balitrip/mbt-cart/assets';
    public $css = [];

    public $js = [
        'js/basket.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
