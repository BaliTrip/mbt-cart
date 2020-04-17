<?php

namespace balitrip\mbtcart\models;

use Yii;

/**
 * Class StoreMeals
 * @package balitrip\mbtcart\models
 *
 * @property bool $spicy;
 * @property bool $vegetarian;
 *
 */
class StoreMeals extends StoreItems
{
    public function getSpicy()
    {
        return (bool) $this->meal_spicy;
    }

    public function getVegetarian()
    {
        return (bool) $this->meal_vegetarian;
    }

}
