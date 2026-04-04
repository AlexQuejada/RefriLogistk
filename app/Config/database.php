<?php

namespace Config;

class Database
{
    
    public static function getConfig()
    {
        return [
            'host' => 'localhost',
            'dbname' => 'refrites_db',
            'user' => 'root',
            'pass' => '',
            'charset' => 'utf8mb4',
            'options' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false
            ]
        ];
    }
}