<?php
namespace Models;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=' . \MYSQL_HOST . ';dbname=' . \MYSQL_NAME . ';port=' . \MYSQL_PORT . ';charset=utf8',
                    \MYSQL_USER,
                    \MYSQL_PASSWORD
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new \RuntimeException('Erreur connexion base de données : ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
