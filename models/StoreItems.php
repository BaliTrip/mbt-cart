<?php

namespace balitrip\mbtcart\models;

use Yii;
/**
 * Class StoreItems
 * @package balitrip\models
 *
 * @property string $name;
 * @property string $shortInfo;
 * @property string $description
 * @property int $price
 */
class StoreItems extends \yii\base\Model
{
    public $id;
    public $name;
    public $description;
    public $products;
    public $preview;
    public $price;
    public $shortInfo;
    public $meal_spicy;
    public $meal_vegetarian;
    public $details;

    private $categories;

    public function getShortInfo()
    {
        return $this->{'short_info_'.Yii::$app->language} ?? $this->short_info_en;
    }

    public function getDescription()
    {
        return $this->{'description_'.Yii::$app->language} ?? $this->description_en;
    }

    public function getCategories()
    {
        if ($this->categories === null) {
            $this->categories = $this->products ? array_map(function ($data) {
                $model = new StoreCategories();
                $model->setAttributes($data, false);
                return $model;
            }, $this->products) : [];
        }
        return $this->categories;
    }
}
