<?php

namespace App\Core;

use PDO;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (self::$connection === null) {
            self::$connection = new PDO('pgsql:host=postgres;dbname=bus_schedule', 'user', 'password');
        }

        return self::$connection;
    }
}
