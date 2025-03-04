<?php

namespace App;

use App\Adapters\DatabaseAdapter;
use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct(private DatabaseAdapter $adapter)
    {
        try {
            $this->connection = $adapter->connect();
        } catch (PDOException $e) {
            Logger::getInstance()->log("Database Connection Failed: " . $e->getMessage());
            die("Database Connection Error");
        }
    }

    public static function getInstance(DatabaseAdapter|null $adapter = null): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database($adapter);
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}