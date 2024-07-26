<?php

namespace App\Factories\Products;

use App\Strategies\Concerns\ProductStrategyInterface;
use App\Strategies\Products\BookStrategy;
use App\Strategies\Products\DVDStrategy;
use App\Strategies\Products\FurnitureStrategy;

class ProductStrategyFactory
{
    protected const STRATEGIES = [
        'DVD' => DVDStrategy::class,
        'Book' => BookStrategy::class,
        'Furniture' => FurnitureStrategy::class,
    ];

    public static function make($type): ProductStrategyInterface
    {
        if (!isset(self::STRATEGIES[$type])) {
            throw new \InvalidArgumentException("Invalid product type");
        }

        $strategy = self::STRATEGIES[$type];

        return new $strategy;
    }

    public static function getTypes(): array
    {
        return array_keys(self::STRATEGIES);
    }
}
