<?php

namespace balitrip\mbtcart;

use yii\web\AssetBundle;

/**
 * Mbt Cart widget assets class
 */
class Assets extends AssetBundle
{
    public $sourcePath = '@balitrip/mbtcart/assets';
    public $css = [];

    public $js = [
        'js/basket.js',
    ];
}
