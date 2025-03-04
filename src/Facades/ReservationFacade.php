<?php

namespace App\Facades;

use App\Logger;
use App\QueryBuilder;
use App\Services\NotificationService;
use App\Services\PaymentService;
use App\Services\ReservationService;
use App\Strategies\PaymentStrategy;
use App\Strategies\PaypalStrategy;
use Exception;

class ReservationFacade
{
    private PaymentService $paymentService;
    private NotificationService $notificationService;
    private ReservationService $validator;

    public function __construct(protected PaymentStrategy $paymentStrategy)
    {
        $this->paymentService = new PaymentService($paymentStrategy);
        $this->notificationService = new NotificationService();
        $this->validator = new ReservationService();
    }

    public function reserve(string $type, array $data): string
    {
        try {
            // Step 1: Validate availability
            if (!$this->validator->isDateAvailable($type, $data['date'])) {
                Logger::getInstance()->log("Reservation failed: No availability for $type on {$data['date']}.");
                return "Sorry, no availability for $type on {$data['date']}.";
            }

            // Step 2: Process Payment
            $paymentSuccess = $this->paymentService->processPayment($data['user_id'], $type, 100.00);
            if (!$paymentSuccess) {
                Logger::getInstance()->log("Reservation failed: Payment issue.");
                return "Payment failed. Please try again.";
            }

            // Step 3: Store Reservation
            $queryBuilder = new QueryBuilder();
            // Insert reservation into database

            Logger::getInstance()->log("Reservation stored for user {$data['user_id']} on {$data['date']}.");

            // Step 4: Send Notification
            $this->notificationService->sendConfirmation($data['user_id'], $type, $data['date']);
            if ($this->paymentStrategy instanceof PaypalStrategy) {
                Logger::getInstance()->log("User {$data['user_id']} paid extra for PayPal fees.");
            }

            Logger::getInstance()->log("New $type reservation made for user {$data['user_id']} on {$data['date']}.");
            return "Reservation successful for $type on {$data['date']}.";
        } catch (Exception $e) {
            Logger::getInstance()->log("Reservation failed: " . $e->getMessage());
            return "Reservation failed.";
        }
    }
}