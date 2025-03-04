<?php

namespace App\Factories;

use App\Models\Hotel;
use App\Models\Model;
use App\Models\Restaurant;

class ModelFactory
{
    public static function create(string $type): Model
    {
        switch ($type) {
            case 'hotel':
                return (new Hotel())->save(['name' => 'Hotel California', 'stars' => 5, 'price' => 100]);
            case 'restaurant':
                return (new Restaurant())->save(['name' => 'Burger Palace', 'chef' => 'Gordon Ramsay', 'price' => 50]);
            default:
                throw new \InvalidArgumentException('Invalid model type');
        }
    }
}