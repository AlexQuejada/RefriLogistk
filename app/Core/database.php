<?php

namespace Core;

use PDO;
use PDOException;
use Config\Database as DatabaseConfig;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        try {
            $config = DatabaseConfig::getConfig();
            
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            
            $this->connection = new PDO(
                $dsn,
                $config['user'],
                $config['pass'],
                $config['options']
            );
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}