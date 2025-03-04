<?php

namespace App\Services;

use App\Logger;
use App\Strategies\PaymentStrategy;

class PaymentService
{
    private PaymentStrategy $paymentStrategy;

    public function __construct(PaymentStrategy $paymentStrategy)
    {
        $this->paymentStrategy = $paymentStrategy;
    }

    public function processPayment(int $userId, string $type, float $amount): bool
    {
        return $this->paymentStrategy->pay($userId, $type, $amount);
    }
}