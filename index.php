<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Adapters\SqliteAdapter;
use App\Database;
use App\Facades\ReservationFacade;
use App\Factories\ModelFactory;
use App\QueryBuilder;
use App\Strategies\CreditStrategy;
use App\Strategies\PaypalStrategy;

$db = Database::getInstance(new SqliteAdapter())->getConnection();


$query = (new QueryBuilder())
    ->table('reservations')
    ->get();
$model = ModelFactory::create("hotel");

$reservationFacade = new ReservationFacade(new PaypalStrategy());
$response = $reservationFacade->reserve('hotel', [
    'user_id' => 1,
    'date' => '2025-03-15'
]);