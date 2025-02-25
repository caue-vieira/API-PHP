<?php
namespace App\Database;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): ?PDO {
        if(self::$connection === null) {
            try {
                $host = "localhost";
                $dbname = "OEEVipel";
                $username = "postgres";
                $password = "vipel";
                $port = "5432";

                self::$connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Lança exceções em caso de erro
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Retorna dados em formato de array associativo
                    PDO::ATTR_EMULATE_PREPARES => false //Usa prepared statements
                ]);
            } catch(PDOException $e) {
                die("Ocorreu um erro ao conectar com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}