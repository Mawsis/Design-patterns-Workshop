<?php

namespace App;

use App\Adapters\SqliteAdapter;
use PDO;

class QueryBuilder
{
    private PDO $connection;
    private string $table;
    private array $columns = ['*'];
    private array $conditions = [];
    private ?string $limit = null;

    public function __construct()
    {
        $this->connection = Database::getInstance(new SqliteAdapter())->getConnection();
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function select(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function where(string $column, string $operator, $value): self
    {
        $this->conditions[] = "$column $operator '$value'";
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = "LIMIT $limit";
        return $this;
    }

    public function get(): array
    {
        $sql = "SELECT " . implode(", ", $this->columns) . " FROM $this->table";

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }

        if ($this->limit) {
            $sql .= " " . $this->limit;
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}