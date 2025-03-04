<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Adapters\SqliteAdapter;
use App\Database;

$db = Database::getInstance(new SqliteAdapter())->getConnection();

// Create `hotels` table
$db->exec("
    CREATE TABLE IF NOT EXISTS hotels (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        stars INTEGER NOT NULL,
        price REAL NOT NULL
    );
");

// Create `restaurants` table
$db->exec("
    CREATE TABLE IF NOT EXISTS restaurants (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        chef TEXT NOT NULL,
        price REAL NOT NULL
    );
");

// Create `reservations` table
$db->exec("
    CREATE TABLE IF NOT EXISTS reservations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        type TEXT NOT NULL CHECK(type IN ('hotel', 'restaurant')),
        date TEXT NOT NULL
    );
");

// Sample hotel data
$hotels = [
    ['name' => 'Grand Hotel', 'stars' => 5, 'price' => 250.00],
    ['name' => 'Sunset Resort', 'stars' => 4, 'price' => 180.50],
];

// Sample restaurant data
$restaurants = [
    ['name' => 'Gourmet Bistro', 'chef' => 'Alice Waters', 'price' => 75.00],
    ['name' => 'Steakhouse Elite', 'chef' => 'Gordon Ramsay', 'price' => 120.00],
];

// Insert hotels
$stmt = $db->prepare("INSERT INTO hotels (name, stars, price) VALUES (:name, :stars, :price)");
foreach ($hotels as $hotel) {
    $stmt->execute($hotel);
}

// Insert restaurants
$stmt = $db->prepare("INSERT INTO restaurants (name, chef, price) VALUES (:name, :chef, :price)");
foreach ($restaurants as $restaurant) {
    $stmt->execute($restaurant);
}

// Sample reservations
$reservations = [
    ['user_id' => 1, 'type' => 'hotel', 'date' => '2025-03-10'],
    ['user_id' => 2, 'type' => 'restaurant', 'date' => '2025-03-11'],
    ['user_id' => 3, 'type' => 'hotel', 'date' => '2025-03-12'],
];

$stmt = $db->prepare("INSERT INTO reservations (user_id, type, date) VALUES (:user_id, :type, :date)");
foreach ($reservations as $reservation) {
    $stmt->execute($reservation);
}

echo "Database seeded successfully!\n";