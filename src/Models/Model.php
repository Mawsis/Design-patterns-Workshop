<?php

namespace App\Models;

use App\Database;
use App\QueryBuilder;

abstract class Model
{
    protected string $table;
    protected QueryBuilder $queryBuilder;
    protected array $attributes;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
    }

    public function all(): array
    {
        return $this->queryBuilder->table($this->table)->get();
    }
    public function save(array $data)
    {
        $db = Database::getInstance()->getConnection();
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_values($data));
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }
}