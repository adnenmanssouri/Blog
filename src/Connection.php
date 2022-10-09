<?php

namespace App;

use \PDO;

class Connection {

    public static function getPdo(): PDO
    {
        return new PDO('mysql:dbname=blog;host=127.0.0.1', 'pepperandegg', 'password', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
