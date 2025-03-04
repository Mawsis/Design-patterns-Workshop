<?php

namespace App\Adapters;

use PDO;

interface DatabaseAdapter
{
    public function connect(): PDO;
}