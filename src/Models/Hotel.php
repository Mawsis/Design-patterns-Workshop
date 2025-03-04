<?php

namespace App\Models;

class Hotel extends Model
{
    protected string $table = 'hotels';
    protected array $attributes = ['name', 'stars', 'price'];
    public string $name;
    public string $price;
    public string $stars;
}