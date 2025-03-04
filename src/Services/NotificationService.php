<?php

namespace App\Services;

use App\Logger;

class NotificationService
{
    public function sendConfirmation(int $userId, string $type, string $date): void
    {
        Logger::getInstance()->log("Sent confirmation email to User $userId for $type reservation on $date.");
    }
}