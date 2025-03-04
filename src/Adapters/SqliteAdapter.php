<?php

namespace App\Adapters;

use PDO;

class SqliteAdapter implements DatabaseAdapter
{
    public function connect(): PDO
    {
        return new PDO('sqlite:reservations.db', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}