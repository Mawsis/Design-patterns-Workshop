<?php

namespace App\Strategies;

use App\Logger;

class CreditStrategy implements PaymentStrategy
{
    public function pay(int $userId, string $type, float $amount): bool
    {
        //DO CREDIT CARD STUFF
        Logger::getInstance()->log("User $userId paid $$amount for $type reservation via Credit Card.");
        return true; // Simulating successful payment
    }
}