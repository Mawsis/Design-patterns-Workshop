<?php

namespace App\Services;

use App\QueryBuilder;

class ReservationService
{
    public function isDateAvailable(string $type, string $date): bool
    {
        $queryBuilder = new QueryBuilder();
        $existingReservations = $queryBuilder->table('reservations')
            ->where('type', '=', $type)
            ->where('date', '=', $date)
            ->get();

        return count($existingReservations) < 5; // Allow max 5 reservations per day
    }
}