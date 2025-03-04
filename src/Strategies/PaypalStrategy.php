<?php

namespace App\Strategies;

use App\Logger;

class PaypalStrategy implements PaymentStrategy
{
    public function pay(int $userId, string $type, float $amount): bool
    {
        //DO PAYPAL STUFF
        Logger::getInstance()->log("User $userId paid $$amount for $type reservation via PayPal.");
        return true; // Simulating successful payment
    }
}