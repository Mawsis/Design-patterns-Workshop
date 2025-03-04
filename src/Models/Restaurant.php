<?php

namespace App\Models;

class Restaurant extends Model
{
    protected string $table = 'restaurants';
    protected array $attributes = ['name', 'chef', 'price'];
    public string $name;
    public string $chef;
    public string $price;
}