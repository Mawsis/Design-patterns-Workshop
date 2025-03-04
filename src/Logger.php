<?php

namespace App;

class Logger
{
    private static ?Logger $instance = null;

    private function __construct() {}

    public static function getInstance(): Logger
    {
        if (self::$instance === null) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public function log(string $message)
    {
        print_r(date('Y-m-d H:i:s') . " - " . $message . PHP_EOL);
        file_put_contents('app.log', date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
    }
}