<?php

namespace App\Factories\Products;

use App\Strategies\Concerns\ProductStrategyInterface;
class ProductStrategyFactory
{
    protected static $types = null;

    public static function make($type): ProductStrategyInterface
    {
        $strategy = 'App\Strategies\Products\\' . $type . 'Strategy';

        try {
            return new $strategy;
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException("Invalid product type");
        }
    }

    public static function getTypes(): array
    {
        if (!self::$types) {
            $path = base_path('App/Strategies/Products');
    
            $files = glob($path . '/*');
    
            $types = [];
            
            foreach ($files as $file) {
                $basename = basename($file);
    
                $type = str_replace('Strategy.php', '', $basename);
    
                if (!in_array($type, $types)) {
                    $types[] = $type;
                }
            }
            
            self::$types = $types;
        }
        
        return self::$types;
    }
}
