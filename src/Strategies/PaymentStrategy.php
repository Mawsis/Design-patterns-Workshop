<?php

namespace App\Strategies;

interface PaymentStrategy
{
    public function pay(int $userId, string $type, float $amount): bool;
}